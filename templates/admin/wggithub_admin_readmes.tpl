<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $formFilter|default:''}>
	<div class="pull-right"><{$formFilter}></div>
<{/if}>

	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_ID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_REPOID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_TYPE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_CONTENT}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_ENCODING}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_DOWNLOADURL}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_BASEURL}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_README_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
			</tr>
		</thead>
		<tbody>
		<{if $readmes_count|default:''}>
			<{foreach item=readme from=$readmes_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$readme.id}></td>
				<td class='center'><{$readme.repoid}></td>
				<td class='center'><{$readme.name}></td>
				<td class='center'><{$readme.type}></td>
				<td class='center'><{$readme.content_short}></td>
				<td class='center'><{$readme.encoding}></td>
				<td class='center'><{$readme.downloadurl}></td>
				<td class='center'><{$readme.baseurl}></td>
				<td class='center'><{$readme.datecreated}></td>
				<td class='center'><{$readme.submitter}></td>
				<td class="center  width5">
					<a href="readmes.php?op=edit&amp;rm_id=<{$readme.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> readmes" /></a>
					<a href="readmes.php?op=delete&amp;rm_id=<{$readme.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> readmes" /></a>
				</td>
			</tr>
			<{/foreach}>
		<{else}>
			<tr class='<{cycle values='odd, even'}>'>
				<td colspan='11' class='center'><{$noData|default:''}></td>
			</tr>
		<{/if}>
		</tbody>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav|default:''}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{if $form|default:''}>
	<{$form}>
<{/if}>
<{if $error|default:''}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
