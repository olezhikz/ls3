{**
 * Форма поиска по тегам
 *
 * @styles css/forms.css
 *}

{include 'components/search_form/search_form.tpl'
		sName         = 'tags'
		sMods         = $smarty.local.sMods
		sPlaceholder  = {lang 'tags.search.label'}
		sClasses      = 'js-tag-search-form'
		sInputClasses = 'autocomplete-tags js-tag-search'
		sInputName    = 'tag'
		sValue        = $sTag|escape}