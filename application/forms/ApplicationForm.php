<?php

/**
 * (c) Hashin Panakkaparambil <hashinp@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Core\Transformation\ObjectFactoryV2;

/**
 * Description of ApplicationForm
 *
 * @author hashinpanakkaparambil
 */
class ApplicationForm extends Zend_Form
{
    protected  $objectFactory;
    

    protected function smallInputs()
    {
        foreach ($this->getElements() as $elem) {
            if ($elem->getType() != 'Zend_Form_Element_Submit') {
                $elem->setAttrib('class', 'input-small');
            }
        }
        return $this;
    }
    
    protected function largeInputs()
    {
        foreach ($this->getElements() as $elem) {
            if ($elem->getType() != 'Zend_Form_Element_Submit') {
                $elem->setAttrib('class', 'xlarge');
            }
        }
        return $this;
    }

    protected function viewScript($script)
    {
        //set the view script decorator for customization
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => $script))
        ));
    }
    
    protected function setRequired(array $elems)
    {
        foreach ($elems as $elem) {
            
            if ($elem instanceof \Zend_Form_Element) {
                $elem->setRequired(true);
            } else if (is_string($elem)) {
                $elemObj = $this->getElement($elem);
                if (!$elemObj) {
                    throw new UnexpectedValueException(sprintf(
                        'Element does not exist', $elem));
                }
                $elemObj->setRequired(true);
            }
        }
    }    

    public function __construct()
    {
        $this->objectFactory = new ObjectFactoryV2();        
        parent::__construct();

        $this->setMethod('post');
        $this->setDisableLoadDefaultDecorators(true);
        $this->setElementDecorators(array('ViewHelper'));
    }

    public function createHiddenProduct($value = '')
    {
        $this->product = new Zend_Form_Element_Hidden('product');
        $this->product->setValue($value);
        $this->product->setRequired(true);
        $this->product->addValidator('Digits');
        $this->addElement($this->product);
        return $this;
    }

    protected function createHiddenRelease($value = '')
    {
        $this->release = new Zend_Form_Element_Hidden('release');
        $this->release->setValue($value);
        $this->release->setRequired(false);
        $this->release->addValidator('Digits');
        $this->addElement($this->release);
        return $this;
    }

    protected function createSubmit($text)
    {
        $this->submit = new Zend_Form_Element_Submit(
                'submit', $text);
        $this->submit->setAttrib('class', 'btn primary');
        $this->addElement($this->submit);

        return $this;
    }

    protected function addSecondaryButton($id, $text)
    {
        $this->$id = new Zend_Form_Element_Button($text);
        $this->$id->setAttrib('class', 'btn secondary');
        $this->addElement($this->$id);
        return $this;
    }

}