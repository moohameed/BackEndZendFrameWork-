<?php
namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PwdnewFilter extends InputFilter
{
	public function __construct($sm)
	{
		
		$this->add(array(
            'name'       => 'mailUser',
            'required'   => true,
            'validators' => array(
                array(
                   // 'name' => 'EmailAddress'
                ),
				array(),
            ),
        ));

        
		
		

				
	}
}