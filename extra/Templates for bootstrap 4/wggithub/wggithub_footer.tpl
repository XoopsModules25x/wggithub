<div class=""><{$copyright}></div>

<{if $pagenav|default:'' != ''}>
    <div class='text-right'><{$pagenav}></div>
<{/if}>
<br>
<{if $xoops_isadmin|default:'' != ''}>
    <hr />
    <p class="text-center"><a class="btn btn-danger" href="<{$admin}>"><span class="fa fa-wrench fa-lg"></span> <{$smarty.const._MA_WGGITHUB_ADMIN}></a></p>
<{/if}>

<{if $comment_mode|default:''}>
    <div class='pad2 marg2'>
        <{if $comment_mode == "flat"}>
            <{include file='db:system_comments_flat.tpl' }>
        <{elseif $comment_mode == "thread"}>
            <{include file='db:system_comments_thread.tpl' }>
        <{elseif $comment_mode == "nest"}>
            <{include file='db:system_comments_nest.tpl' }>
        <{/if}>
    </div>
<{/if}>
<{include file='db:system_notification_select.tpl' }>
