<?php

namespace App\Entity;

use App\Repository\EvaluationFormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationFormRepository::class)
 */
class EvaluationForm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $percent;

    /**
     * @ORM\OneToMany(targetEntity=EvaluationFormOption::class, mappedBy="evaluation", orphanRemoval=true)
     */
    private $evaluationFormOptions;

    /**
     * @ORM\ManyToOne(targetEntity=EvaluationForm::class, inversedBy="childs")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=EvaluationForm::class, mappedBy="parent")
     */
    private $childs;


    public function __toString()
    {
       return $this->name; 
    }
    public function __construct()
    {
        $this->evaluationFormOptions = new ArrayCollection();
        $this->childs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * @return Collection|EvaluationFormOption[]
     */
    public function getEvaluationFormOptions(): Collection
    {
        return $this->evaluationFormOptions;
    }

    public function addEvaluationFormOption(EvaluationFormOption $evaluationFormOption): self
    {
        if (!$this->evaluationFormOptions->contains($evaluationFormOption)) {
            $this->evaluationFormOptions[] = $evaluationFormOption;
            $evaluationFormOption->setEvaluation($this);
        }

        return $this;
    }

    public function removeEvaluationFormOption(EvaluationFormOption $evaluationFormOption): self
    {
        if ($this->evaluationFormOptions->removeElement($evaluationFormOption)) {
            // set the owning side to null (unless already changed)
            if ($evaluationFormOption->getEvaluation() === $this) {
                $evaluationFormOption->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
