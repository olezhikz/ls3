{**
 * Теги
 *
 * @styles css/blocks.css
 *}

{extends 'components/block/block.tpl'}

{block 'block_title'}
	{$aLang.block_tags}
{/block}

{block 'block_options' append}
	{$mods = "{$mods} tags"}
{/block}

{block 'block_nav'}
	{include 'components/nav/nav.tabs.tpl' sName='block_tags' sActiveItem='all' sMods='pills' sClasses='' aItems=[
		[ 'name' => 'all', 'text' => {lang 'tags.block_tags.nav.all'}, 'pane' => 'js-tab-pane-tags-all' ],
		[ 'name' => 'my',  'text' => {lang 'tags.block_tags.nav.favourite'}, 'pane' => 'js-tab-pane-tags-my', 'is_enabled' => !! $oUserCurrent ]
	]}
{/block}

{block 'block_content'}
	{include 'components/tags/search_form.tags.tpl' sMods='light'}

	<div data-type="tab-panes">
		<div class="tab-pane" data-type="tab-pane" id="js-tab-pane-tags-all" style="display: block">
			{include 'components/tags/tag_cloud.tpl' aTags=$aTags sTagsUrl='{router page=\'tag\'}{$oTag->getText()|escape:\'url\'}/'}
		</div>

		{if $oUserCurrent}
			<div class="tab-pane" data-type="tab-pane" id="js-tab-pane-tags-my">
				{include 'components/tags/tag_cloud.tpl' aTags=$aTagsUser sTagsUrl='{router page=\'tag\'}{$oTag->getText()|escape:\'url\'}/'}
			</div>
		{/if}
	</div>
{/block}