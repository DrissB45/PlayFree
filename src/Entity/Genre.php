<?php

namespace App\Entity;

use DateTime;
use App\Entity\Game;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[Vich\Uploadable]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'genres', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?Datetime $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Game::class)]
    private Collection $game;

    public function __construct()
    {
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game->add($game);
            $game->setGenre($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getGenre() === $this) {
                $game->setGenre(null);
            }
        }

        return $this;
    }
}
