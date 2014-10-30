{**
 * Добавление в друзья
 *
 * @styles css/modals.css
 *}

{extends 'components/modal/modal.tpl'}

{block 'modal_id'}modal-add-friend{/block}
{block 'modal_class'}js-modal-default{/block}
{block 'modal_title'}
	{lang name='user.friends.form.title'}
{/block}

{block 'modal_content'}
	{* TODO: Form validation (front-end / back-end) *}
	<form id="add_friend_form" class="js-user-friend-form">
		{include 'components/field/field.textarea.tpl'
				 name     = 'add_friend_text'
				 rules    = [ 'required' => true, 'rangelength' => '[2,200]' ]
				 rows     = 3
				 noMargin = true
				 label    = {lang name='user.friends.form.fields.text.label'}}
	</form>
{/block}

{block 'modal_footer_begin'}
	 {include 'components/button/button.tpl' mods='primary' form='add_friend_form' text={lang name='user.friends.form.fields.submit.text'}}
{/block}