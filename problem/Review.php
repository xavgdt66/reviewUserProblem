<?php
//src/Entity/Review.php
namespace App\Entity;
use App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface; // Importation correcte
use App\Repository\ReviewRepository;


#[ORM\Entity]
class Review
{
    // Assurez-vous d'avoir un ID pour cette entité
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $startDate;

    #[ORM\Column(type: 'datetime')]
    private $endDate;

    ////////////////////////////////////////////////////////////////////////////////////

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private $user;


    #[ORM\Column(type: "string", length: 555)]
    private $nom_agence;

    ////////////////////////////////////////////////////////////////////////////////////
    #[ORM\Column(type: 'text', nullable: true)]
    private $comment;
    // Getters et setters


    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getNomAgence() {
        return $this->nom_agence;
    }

    public function setNomAgence($nom_agence) {
        $this->nom_agence = $nom_agence;
    }









    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }




    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    // Méthode de validation
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        if ($this->endDate < $this->startDate) {
            $context->buildViolation('La date de fin doit être postérieure à la date de début.')
                ->atPath('endDate')
                ->addViolation();
        }
    }
}
