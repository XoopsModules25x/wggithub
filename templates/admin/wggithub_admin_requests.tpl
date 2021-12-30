<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<{if $requests_list}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REQUEST_ID}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REQUEST_REQUEST}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REQUEST_RESULT}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REQUEST_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGGITHUB_REQUEST_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGGITHUB_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $requests_count}>
        <tbody>
            <{foreach item=request from=$requests_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$request.id}></td>
                <td class='center'><{$request.request}></td>
                <td class='center'><{$request.result}></td>
                <td class='center'><{$request.datecreated}></td>
                <td class='center'><{$request.submitter}></td>
                <td class="center  width5">
                    <a href="requests.php?op=edit&amp;req_id=<{$request.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> requests" /></a>
                    <a href="requests.php?op=delete&amp;req_id=<{$request.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> requests" /></a>
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
