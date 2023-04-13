<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $formFilter|default:''}>
    <div class="pull-right"><{$formFilter}></div>
<{/if}>

<{if $repositories_count|default:0 > 0 || $noData|default:''}>
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
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_README}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_PRERELEASE}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_RELEASE}></th>
                <{if $autoApproved|default:''}>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_APPROVED}></th>
                <{/if}>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_STATUS}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REPOSITORY_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
            </tr>
        </thead>
        <tbody>
        <{if $repositories_count|default:''}>
            <{foreach item=repository from=$repositories_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$repository.id}></td>
                <td ><{$repository.nodeid}></td>
                <td ><{$repository.user}></td>
                <td ><{$repository.name}></td>
                <td ><{$repository.fullname}></td>
                <td class='center'><{$repository.createdat}></td>
                <td class='center'><{$repository.updatedat}></td>
                <td ><{$repository.htmlurl}></td>
                <td class='center'><{$repository.readme}></td>
                <td class='center'><{$repository.prerelease}></td>
                <td class='center'><{$repository.release}></td>
                <{if $autoApproved|default:''}>
                <td class='center'>
                    <{if $repository.repo_approved|default:0 == 1}>
                    <a href="repositories.php?op=change_yn&amp;field=repo_approved&amp;value=0&amp;repo_id=<{$repository.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETOFF}>"><img src="<{$wggithub_icons_url_16}>/on.png" alt="<{$smarty.const._AM_WGGITHUB_SETOFF}>" /></a>
                    <{else}>
                    <a href="repositories.php?op=change_yn&amp;field=repo_approved&amp;value=1&amp;repo_id=<{$repository.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._AM_WGGITHUB_SETON}>"><img src="<{$wggithub_icons_url_16}>/off.png" alt="<{$smarty.const._AM_WGGITHUB_SETON}>" /></a>
                    <{/if}>
                </td>
                <{/if}>
                <td class='center'><img src="<{$modPathIcon16}>status<{$repository.status}>.png" alt="<{$repository.status_text}>" title="<{$repository.status_text}>" /></td>
                <td class='center'><{$repository.datecreated}></td>
                <td class='center'><{$repository.submitter}></td>
                <td class="center  width5">
                    <a href="repositories.php?op=edit&amp;repo_id=<{$repository.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> repositories" /></a>
                    <a href="repositories.php?op=delete&amp;repo_id=<{$repository.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> repositories" /></a>
                </td>
            </tr>
            <{/foreach}>
        <{else}>
            <tr class='<{cycle values='odd, even'}>'>
                <td colspan='16' class='center'><{$noData|default:''}></td>
            </tr>
        <{/if}>
        </tbody>
    </table>
    <div class="clear">&nbsp;</div>
    <{if !empty($pagenav)}>
        <div class="xo-pagenav floatright"><{$pagenav}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if !empty($form)}>
    <{$form}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
