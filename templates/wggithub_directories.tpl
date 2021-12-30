<{include file='db:wggithub_header.tpl' }>

<{if $directoriesCount > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby}>'><{$smarty.const._MA_WGGITHUB_DIRECTORIES_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=directory from=$directories}>
				<td>
					<div class='panel panel-<{$panel_type}>'>
						<{include file='db:wggithub_directories_item.tpl' }>
					</div>
				</td>
				<{if $directory.count is div by $divideby}>
					</tr><tr>
				<{/if}>
				<{/foreach}>
			</tr>
		</tbody>
		<tfoot><tr><td>&nbsp;</td></tr></tfoot>
	</table>
</div>
<{/if}>
<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<{$error}>
<{/if}>

<{include file='db:wggithub_footer.tpl' }>
