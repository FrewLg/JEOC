<?php

namespace App\Entity;

use App\Repository\EvaluationFormOptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationFormOptionRepository::class)
 */
class EvaluationFormOption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EvaluationForm::class, inversedBy="evaluationFormOptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluation(): ?EvaluationForm
    {
        return $this->evaluation;
    }
    public function getMax()
    {
        if ($this->type == 1) {
            
            return  explode('-',$this->getValue())[1];
          }
          return 0;
    }
    public function getMin()
    {
        if ($this->type == 1) {
          return  explode('-',$this->getValue())[0];
        }
        return 0;
    }

    public function setEvaluation(?EvaluationForm $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
