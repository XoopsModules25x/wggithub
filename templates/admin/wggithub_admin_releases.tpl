<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $formFilter|default:''}>
    <div class="pull-right"><{$formFilter}></div>
<{/if}>

<{if $releases_count|default:0 > 0 || $noData|default:''}>
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
        <tbody>
        <{if $releases_count|default:''}>
            <{foreach item=release from=$releases_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$release.id}></td>
                <td ><{$release.repoid}></td>
                <td class='center'><{$release.type}></td>
                <td ><{$release.name}></td>
                <td class='center'><{$release.prerelease}></td>
                <td class='center'><{$release.publishedat}></td>
                <td ><{$release.tarballurl}></td>
                <td ><{$release.zipballurl}></td>
                <td class='center'><{$release.datecreated}></td>
                <td class='center'><{$release.submitter}></td>
                <td class="center  width5">
                    <a href="releases.php?op=edit&amp;rel_id=<{$release.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> releases" /></a>
                    <a href="releases.php?op=delete&amp;rel_id=<{$release.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> releases" /></a>
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
<{/if}>
<{if $form|default:''}>
    <{$form}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
