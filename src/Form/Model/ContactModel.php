<?php

namespace App\Form\Model;

class ContactModel
{
	private $lastname;
	private $email;
	private $message;


	public function setLastname(?string $lastname):void
	{
		$this->lastname = $lastname;
	}

	public function getLastname():?string
	{
		return $this->lastname;
	}

	public function setEmail(?string $email):void
	{
		$this->email = $email;
	}

	public function getEmail():?string
	{
		return $this->email;
	}

	public function setMessage(?string $message):void
	{
		$this->message = $message;
	}

	public function getMessage():?string
	{
		return $this->message;
	}

}