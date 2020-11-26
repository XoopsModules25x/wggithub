<{include file='db:wggithub_header.tpl' }>

<{if $repositoriesCount > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby}>'><{$smarty.const._MA_WGGITHUB_REPOSITORIES_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=repository from=$repositories}>
				<td>
					<div class='panel panel-<{$panel_type}>'>
						<{include file='db:wggithub_repositories_item.tpl' }>
					</div>
				</td>
				<{if $repository.count is div by $divideby}>
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
