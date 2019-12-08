<?php

namespace App\EventSubscriber\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtWorkFormSubscriber implements EventSubscriberInterface
{
    public function postSetData(FormEvent $event):void
    {

        $model = $event->getData();
        $form = $event->getForm();
        $entity = $form->getData();

        // modifier les contraintes du champ fichier
        // si l'entité est mise à jour, pas de contraintes
        $constraints = $entity->getId() ? [] : [
            new NotBlank([
                'message' => "L'image est obligatoire"
            ]),
            new Image([
                'mimeTypesMessage' => "Vous devez sélectionner une image",
                'mimeTypes' => [ 'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp' ]
            ])
        ];

        $form->add('picture', FileType::class, [
            'data_class' => null, // éviter une erreur lors de la modification d'une entité
            'constraints' => $constraints
        ]);

    }

    public static function getSubscribedEvents():array
    {
        return [
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }
}
