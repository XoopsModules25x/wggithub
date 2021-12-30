<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<h3><{$repositories_result}></h3>
<{if $repositories_count}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class='center'><{$smarty.const._AM_WGGITHUB_BROKEN_TABLE}></th>
				<th class='center'><{$smarty.const._AM_WGGITHUB_BROKEN_MAIN}></th>
				<th class='center width5'><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
			</tr>
		</thead>
		<tbody>
			<{foreach item=repository from=$repositories_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$repository.table}></td>
				<td class='center'><{$repository.main}></td>
				<td class='center width5'>
					<a href='repositories.php?op=edit&amp;<{$repository.key}>=<{$repository.keyval}>' title='<{$smarty.const._EDIT}>'><img src='<{xoModuleIcons16 edit.png}>' alt='repositories' /></a>
					<a href='repositories.php?op=delete&amp;<{$repository.key}>=<{$repository.keyval}>' title='<{$smarty.const._DELETE}>'><img src='<{xoModuleIcons16 delete.png}>' alt='repositories' /></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
	</table>
	<div class='clear'>&nbsp;</div>
	<{if $pagenav}>
		<div class='xo-pagenav floatright'><{$pagenav}></div>
		<div class='clear spacer'></div>
	<{/if}>
<{else}>
	<{if $nodataRepositories}>
		<div>
			<{$nodataRepositories}><img src='<{xoModuleIcons32 button_ok.png}>' alt='repositories' />
		</div>
		<div class='clear spacer'></div>
		<br />
		<br />
	<{/if}>
<{/if}>
<br />
<br />
<br />
<{if $error}>
	<div class='errorMsg'>
<strong><{$error}></strong>	</div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
