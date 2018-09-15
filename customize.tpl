<div id="short_description_blockf">
<h2>{l s='Product Dimensions' mod='customize'}:</h2>
<div id="feat"> 
      
    <form method="post" action="{$customizationFormTarget}" enctype="multipart/form-data" id="customizationForm">
			<p>
				{l s='After saving your custom product size, do not forget to add it to your cart.' mod='customize'}
			</p>
		
			<div class="clear"></div>
			{if $product->text_fields|intval}
			<h2>{l s='Texts' mod='customize'}</h2>
			<ul id="text_fields">
				{counter start=0 assign='customizationField'}
				{foreach from=$customizationFields item='field' name='customizationFields'}
					{if $field.type == 1}
						<li>{assign var='key' value='textFields_'|cat:$product->id|cat:'_'|cat:$field.id_customization_field}
							{if !empty($field.name)}{$field.name}{/if}{if $field.required}<sup>*</sup>{/if}
							<input type="text" name="textField{$field.id_customization_field}" id="textField{$customizationField}" class="customization_block_input" style="width:150px" />{if isset($textFields.$key)}{$textFields.$key|stripslashes}{/if}
						</li>
						{counter}
					{/if}
				{/foreach}
			</ul>
			{/if}

			<p style="clear: left;" id="customizedDatas">
				<input type="text" name="lenght" id="quantityBackup" value="1" />
				<input type="text" name="width" value="1" />
	
				<span id="ajax-loader" style="display:none"><img src="{$img_ps_dir}loader.gif" alt="loader" /></span>
			</p>
		</form>
		<p class="clear required"><sup>*</sup> {l s='required fields' mod='customize'}</p>       
 	</div>
 </div>
    
 