<?php

if(!defined('_PS_VERSION_'))
exit;

class Customize extends Module
{

	private $_html = '';

	private $_postErrors = array();
	
	function __construct()
	{
		$this->name = 'customize';
		$this->tab = 'front_office_customize';
		$this->author = 'Richard';
		$this->need_instance = 1;
		$this->version = '1.1';

		parent::__construct();
		
		$this->displayName = $this->l('Product Dimensions');
		$this->description = $this->l('Customize Dimenstions of products');

	}

	function install()
	{
		if (
			!Configuration::updateValue('CUSTOMIZE_DIMENSION', 12) || 
			!Configuration::updateValue('CUSTOMIZE_WIDTH', "3 feet") || 
			!Configuration::updateValue('CUSTOMIZE_LENGTH', "4 feet") ||   
			!parent::install() || 
			!$this->registerHook('extraright') || 
			!$this->registerHook('header'))
			return false;
		
		return true;
	}
	
		public function postProcess()
	{
		global $currentIndex;

		$errors = false;
		
		if ($errors)
			echo $this->displayError($errors);
	}


		public function displayForm()
	{
		
  global $cookie;

  	$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
		$languages = Language::getLanguages();
		$iso = Language::getIsoById($defaultLanguage);
		$divLangName = 'link_label';
		$this->_html .= '
		
		'.$this->l('Contribute').'
				<p class="clear">'.$this->l('You can contribute with a donation if our free modules and themes are usefull for you. Click on the link and support us!').'</p>
	';
  

 	return $this->_html;				
	}

	public function getContent()
	{
		
	$this->postProcess();
	global $cookie,$currentIndex;

	if (Tools::isSubmit('submitCustomize'))
		{
			$dimension = intval(Tools::getValue('dimension'));
			$length = Tools::getValue('length');
			$width = Tools::getValue('width');
			Configuration::updateValue('CUSTOMIZE_DIMENSION', $dimension);
			Configuration::updateValue('CUSTOMIZE_LENGTH', $length);
			Configuration::updateValue('CUSTOMIZE_WIDTH', $width);
			$this->_html .= @$errors == '' ? $this->displayConfirmation('Settings updated successfully') : @$errors;

					
		}
	
return $this->displayForm();

	}

public function getProductscath($id_product)
	{
		$result = Db::getInstance()->getRow('
		
		SELECT SUM(od.`product_quantity`) AS totalCount
			FROM '._DB_PREFIX_.'order_detail od 
			WHERE od.product_id = '.$id_product.'');
		
	return $result['totalCount'];
		
		
	}


	public function hookExtraRight($params)
	{
		global $smarty,$customize2,$cookie;
		$feat = new Product;
	
		$id_product = intval(Tools::getValue('id_product'));
		$dimension =  Configuration::get('CUSTOMIZE_DIMENSION', $dimension);
		$length = Configuration::get('CUSTOMIZE_LENGTH', $length);
		$width =  Configuration::get('CUSTOMIZE_WIDTH', $width);
	
	{
		$product = new Product($id_product, true, $cookie->id_lang);
		$textFields = $cookie->getFamily('textFields_'.(int)($product->id));
					foreach ($textFields as $key => $textField)
						$textFields[$key] = str_replace('<br />', "\n", $textField);
					$smarty->assign(array(
							'customizationFields' => ($product->customizable ? $product->getCustomizationFields((int)$cookie->id_lang) : false),
							'ipa_customization' => Tools::getIsset('ipa_customization') ? Tools::getValue('ipa_customization'): '',
							'textFields' => $textFields
						)
					);
		}

		
		$smarty->assign('product', $product);
			
		$smarty->assign('fsize', $dimension);
		$smarty->assign('psversion', _PS_VERSION_);
		
			return $this->display(__FILE__, 'customize.tpl');
	}

}
?>