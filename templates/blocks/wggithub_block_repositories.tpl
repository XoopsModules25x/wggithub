<table class='table table-<{$table_type|default:''}>'>
    <thead>
        <tr class='head'>
            <th>&nbsp;</th>
            <th class='center'><{$smarty.const._MB_WGGITHUB_REPO_NAME}></th>
            <th class='center'><{$smarty.const._MB_WGGITHUB_REPO_HTMLURL}></th>
        </tr>
    </thead>
    <{if count($block)}>
    <tbody>
        <{foreach item=repository from=$block}>
        <tr class='<{cycle values="odd, even"}>'>
            <td class='center'><{$repository.id}></td>
            <td class='center'><{$repository.name}></td>
            <td class='center'><{$repository.htmlurl}></td>
        </tr>
        <{/foreach}>
    </tbody>
    <{/if}>
    <tfoot><tr><td>&nbsp;</td></tr></tfoot>
</table>
