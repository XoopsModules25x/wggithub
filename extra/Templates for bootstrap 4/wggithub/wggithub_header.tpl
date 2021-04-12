<{if $showBreadcrumb|default:false}>
    <{include file='db:wggithub_breadcrumbs.tpl' }>
<{/if}>

<{if $ads|default:'' != ''}>
    <div class='text-center'><{$ads}></div>
<{/if}>
