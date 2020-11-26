<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $repositories_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_ID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_NODEID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_USER}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_FULLNAME}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_CREATEDAT}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_UPDATEDAT}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_HTMLURL}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_PRERELEASE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_RELEASE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_STATUS}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $repositories_count}>
		<tbody>
			<{foreach item=repository from=$repositories_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$repository.id}></td>
				<td class='center'><{$repository.nodeid}></td>
				<td class='center'><{$repository.user}></td>
				<td class='center'><{$repository.name}></td>
				<td class='center'><{$repository.fullname}></td>
				<td class='center'><{$repository.createdat}></td>
				<td class='center'><{$repository.updatedat}></td>
				<td class='center'><{$repository.htmlurl}></td>
				<td class='center'><{$repository.prerelease}></td>
				<td class='center'><{$repository.release}></td>
				<td class='center'><img src="<{$modPathIcon16}>status<{$repository.status}>.png" alt="<{$repository.status_text}>" title="<{$repository.status_text}>" /></td>
				<td class='center'><{$repository.datecreated}></td>
				<td class='center'><{$repository.submitter}></td>
				<td class="center  width5">
					<a href="repositories.php?op=edit&amp;repo_id=<{$repository.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> repositories" /></a>
					<a href="repositories.php?op=delete&amp;repo_id=<{$repository.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> repositories" /></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
