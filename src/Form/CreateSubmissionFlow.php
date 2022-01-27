<?php
namespace App\Form;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class CreateSubmissionFlow extends FormFlow {

	protected function loadStepsConfig() {
		return [
			[
				'label' => 'guidline',
				'form_type' => SubmissionType::class,
			],
			[
				'label' => 'metadata',
				'form_type' => SubmissionType::class,
				'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
					return $estimatedCurrentStepNumber > 1 && $flow->getFormData()->getAgreeToTheTerms();
				},
			],
			[
				'label' => 'teamMember',
				'form_type' => SubmissionType::class,
				
			],
			[
				'label' => 'confirmation',
			],
		];
	}

}