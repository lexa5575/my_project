<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;
    private string $userName;
    private string $title;
    private string $body;
 
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
 
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
 
    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
 
    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }
 
    /**
     * @param  string  $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
 
    /**
     * @param  string  $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
 
    /**
     * @param  string  $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
}
