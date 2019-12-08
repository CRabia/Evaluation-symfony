<?php

namespace App\EventSubscriber\Entity;

use App\Entity\ArtWork;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArtWorkSubscriber implements EventSubscriber
{
	private $stringService;
	private $fileService;

	public function __construct(StringService $stringService, FileService $fileService)
	{
		$this->stringService = $stringService;
		$this->fileService = $fileService;
	}

	public function prePersist(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		if(!$entity instanceof ArtWork){
			return;
		} else {

			if($entity->getPicture() instanceof UploadedFile){
				$this->fileService->upload($entity->getPicture(), 'img/artwork');
				$entity->setPicture( $this->fileService->getFileName() );
			}
		}
	}

	public function postLoad(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		if(!$entity instanceof ArtWork){
			return;
		} else {
			// création d'une propriété dynamique pour stocker le nom de l'image
			$entity->prevImage = $entity->getPicture();
		}
	}

	public function preUpdate(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		if(!$entity instanceof ArtWork){
			return;
		} else {
			// si une image a été sélectionnée
			if($entity->getPicture() instanceof UploadedFile){
				// transfert de la nouvelle image
				$this->fileService->upload($entity->getPicture(), 'img/artwork');
				$entity->setPicture( $this->fileService->getFileName() );

				// supprimer l'ancienne image
				if(file_exists("img/artwork/{$entity->prevImage}")) {
					$this->fileService->remove('img/artwork', $entity->prevImage);
				}
			}
			// si aucune image n'a été sélectionnée
			else {
				$entity->setPicture( $entity->prevImage );
			}
		}
	}

	public function getSubscribedEvents():array
	{
		return [
			Events::prePersist,
			Events::postLoad,
			Events::preUpdate,
		];
	}

}