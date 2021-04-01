<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $logs_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_ID}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_TYPE}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_DETAILS}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_RESULT}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_LOG_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $logs_count|default:''}>
        <tbody>
            <{foreach item=log from=$logs_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$log.id}></td>
                <td ><{$log.type_text}></td>
                <td ><{$log.details}></td>
                <td class='center'><{$log.result_short}></td>
                <td class='center'><{$log.datecreated}></td>
                <td class='center'><{$log.submitter}></td>
                <td class="center  width5">
                    <a href="logs.php?op=edit&amp;log_id=<{$log.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> log" /></a>
                    <a href="logs.php?op=delete&amp;log_id=<{$log.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> log" /></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
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
