<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $directories_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_ID}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_TYPE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_AUTOUPDATE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_ONLINE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_FILTERRELEASE}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGGITHUB_DIRECTORY_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $directories_count}>
		<tbody>
			<{foreach item=directory from=$directories_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$directory.id}></td>
				<td class='center'><{$directory.name}></td>
				<td class='center'><{$directory.type_text}></td>
				<td class='center'>
					<{if $directory.dir_autoupdate == 1}>
						<a href="directories.php?op=change_yn&amp;field=dir_autoupdate&amp;value=0&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETOFF}>"><img src="<{$wggithub_icons_url_16}>/on.png" alt="<{$smarty.const._AM_WGGITHUB_SETOFF}>" /></a>
					<{else}>
						<a href="directories.php?op=change_yn&amp;field=dir_autoupdate&amp;value=1&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETON}>"><img src="<{$wggithub_icons_url_16}>/off.png" alt="<{$smarty.const._AM_WGGITHUB_SETON}>" /></a>
					<{/if}>
				</td>
				<td class='center'>
					<{if $directory.dir_online == 1}>
						<a href="directories.php?op=change_yn&amp;field=dir_online&amp;value=0&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETOFF}>"><img src="<{$wggithub_icons_url_16}>/on.png" alt="<{$smarty.const._AM_WGGITHUB_SETOFF}>" /></a>
					<{else}>
						<a href="directories.php?op=change_yn&amp;field=dir_online&amp;value=1&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETON}>"><img src="<{$wggithub_icons_url_16}>/off.png" alt="<{$smarty.const._AM_WGGITHUB_SETON}>" /></a>
					<{/if}>
				</td>
				<td class='center'>
					<{if $directory.dir_filterrelease == 1}>
						<a href="directories.php?op=change_yn&amp;field=dir_filterrelease&amp;value=0&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETOFF}>"><img src="<{$wggithub_icons_url_16}>/on.png" alt="<{$smarty.const._AM_WGGITHUB_SETOFF}>" /></a>
					<{else}>
						<a href="directories.php?op=change_yn&amp;field=dir_filterrelease&amp;value=1&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETON}>"><img src="<{$wggithub_icons_url_16}>/off.png" alt="<{$smarty.const._AM_WGGITHUB_SETON}>" /></a>
					<{/if}>
				</td>
				<td class='center'><{$directory.datecreated}></td>
				<td class='center'><{$directory.submitter}></td>
				<td class="center  width5">
					<a href="directories.php?op=readgh&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGGITHUB_READGH_DIRECTORY}>"><img src="<{$wggithub_icons_url_16}>/github.png" alt="<{$smarty.const._MA_WGGITHUB_READGH_DIRECTORY}> directories" /></a>
					<a href="directories.php?op=edit&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> directories" /></a>
					<a href="directories.php?op=delete&amp;dir_id=<{$directory.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> directories" /></a>
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
