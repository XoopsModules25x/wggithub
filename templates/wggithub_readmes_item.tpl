<i id='rmId_<{$readme.rm_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
    <span class='col-sm-9 justify'><{$readme.name}></span>
    <span class='col-sm-9 justify'><{$readme.type}></span>
    <span class='col-sm-9 justify'><{$readme.content}></span>
</div>
<div class='panel-foot'>
    <div class='col-sm-12 right'>
        <{if $showItem}>
            <a class='btn btn-success right' href='readmes.php?op=list&amp;#rmId_<{$readme.rm_id}>' title='<{$smarty.const._MA_WGGITHUB_READMES_LIST}>'><{$smarty.const._MA_WGGITHUB_READMES_LIST}></a>
        <{else}>
            <a class='btn btn-success right' href='readmes.php?op=show&amp;rm_id=<{$readme.rm_id}>' title='<{$smarty.const._MA_WGGITHUB_DETAILS}>'><{$smarty.const._MA_WGGITHUB_DETAILS}></a>
        <{/if}>
        <{if $permEdit}>
            <a class='btn btn-primary right' href='readmes.php?op=edit&amp;rm_id=<{$readme.rm_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-danger right' href='readmes.php?op=delete&amp;rm_id=<{$readme.rm_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
        <{/if}>
    </div>
</div>
