<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
	private $stringService;
	private $fileName;

	public function __construct(StringService $stringService)
	{
		$this->stringService = $stringService;
	}

	public function getFileName():string
	{
		return $this->fileName;
	}

	public function upload(UploadedFile $file, string $directory):void
	{
		$this->fileName = "{$this->stringService->getToken()}.{$file->guessClientExtension()}";
		$file->move($directory, $this->fileName);
	}

	public function remove(string $directory, string $fileName):void
	{
		$destination = "$directory/$fileName";
		unlink($destination);
	}
}








