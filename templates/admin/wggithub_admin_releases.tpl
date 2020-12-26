<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $releases_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_ID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_REPOID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_TYPE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_PRERELEASE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_PUBLISHEDAT}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_TARBALLURL}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_ZIPBALLURL}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_RELEASE_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $releases_count}>
		<tbody>
			<{foreach item=release from=$releases_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$release.id}></td>
				<td class='center'><{$release.repoid}></td>
				<td class='center'><{$release.type}></td>
				<td class='center'><{$release.name}></td>
				<td class='center'><{$release.prerelease}></td>
				<td class='center'><{$release.publishedat}></td>
				<td class='center'><{$release.tarballurl}></td>
				<td class='center'><{$release.zipballurl}></td>
				<td class='center'><{$release.datecreated}></td>
				<td class='center'><{$release.submitter}></td>
				<td class="center  width5">
					<a href="releases.php?op=edit&amp;rel_id=<{$release.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> releases" /></a>
					<a href="releases.php?op=delete&amp;rel_id=<{$release.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> releases" /></a>
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
