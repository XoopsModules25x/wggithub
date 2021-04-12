<{include file='db:wggithub_header.tpl' }>

<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<{if $directoriesCount|default:0 > 0}>
    <!-- filter area -->
    <div id="filter_bar" class="tab-filter">
        <{$smarty.const._MA_WGGITHUB_FILTER_SORTBY}>:
        <div class="btn-group btn-group-sm" role="group" aria-label="Filter Sortby">
            <button id="sortbyname" onclick="executeClick('index.php?op=list&fsortby=name&frelease=<{$frelease}>')" type="button" class="btn btn-primary btn-rounded <{if $menu == 0 || $fsortby =='name'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_SORTBY_NAME}></button>
            <button id="sortbyupdate" onclick="executeClick('index.php?op=list&fsortby=update&frelease=<{$frelease}>')" type="button" class="btn btn-primary btn-rounded <{if $menu == 0 || $fsortby =='update'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_SORTBY_UPDATE}></button>
        </div>
        <span id="filter_release_label"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE}>:</span>
        <div id="filter_release_bar" class="btn-group btn-group-sm" role="group" aria-label="Filter Releases">
            <button id="relfinal" onclick="executeClick('index.php?op=list&frelease=final&fsortby=<{$fsortby}>')" type="button" class="btn btn-primary btn-rounded <{if $menu == 0 || $frelease =='final'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_FINAL}></button>
            <button id="relany" onclick="executeClick('index.php?op=list&frelease=any&fsortby=<{$fsortby}>')" type="button" class="btn btn-primary btn-rounded <{if $menu == 0 || $frelease =='any'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_ANY}></button>
            <{if $showBtnAll|default:false}>
                <button id="relall" onclick="executeClick('index.php?op=list&frelease=all&fsortby=<{$fsortby}>')" type="button" class="btn btn-primary btn-rounded <{if $menu == 0 || $frelease =='all'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_ALL}></button>
            <{/if}>
        </div>
    </div>
    <!-- Basic Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link <{if $menu == 0}>active<{/if}>" data-toggle="tab" onclick='javascript:toggleFilters(0);toggleFilterRelease(0);' href="#home"><{$smarty.const._MA_WGGITHUB_INDEX}></a></li>
        <{foreach item=directory from=$directories}>
        <li class="nav-item"><a class="nav-link <{if $menu == $directory.id}>active<{/if}>" data-toggle="tab" onclick='javascript:toggleFilters(1);toggleFilterRelease(<{$directory.dir_filterrelease}>)'  href="#menu<{$directory.id}>"><{$directory.name}></a></li>
        <{/foreach}>
    </ul>
    <div class="tab-content tab-content-main">
        <div id="home" class="maintab tab-pane fade <{if $menu == 0}>active show<{/if}>">
            <p class="center"><img class="tabcontent-logo" src="assets/images/logoModule.png" alt="<{$smarty.const._MA_WGGITHUB_TITLE}>" title="<{$smarty.const._MA_WGGITHUB_TITLE}>"></p>
            <div class="d-flex justify-content-center">
                <div>
                    <h4 class="text-center mb-3"><{$smarty.const._MA_WGGITHUB_DESC}></h4>
                    <{$smarty.const._MA_WGGITHUB_INDEX_DESC}>
                </div>
            </div>    
            <p class="tabcontent-lastupdate"><{$smarty.const._MA_WGGITHUB_INDEX_LASTUPDATE}>: <{$lastUpdate}> GMT</p>
            <{if $apiexceed|default:''}>
                <p><{$smarty.const._MA_WGGITHUB_READGH_ERROR_APILIMIT}></p>
            <{elseif $apierror|default:''}>
                <p><{$smarty.const._MA_WGGITHUB_READGH_ERROR_APIOTHER}></p>
            <{else}>
                <p><{$smarty.const._MA_WGGITHUB_INDEX_UPTODATE}></p>
            <{/if}>
        </div>
        <{foreach item=directory from=$directories}>
        <div id="menu<{$directory.id}>" class="maintab tab-pane fade <{if $menu == $directory.id}>active show<{/if}>">
            <div class="d-flex justify-content-center">
                <div>
                    <h4 class="mt-2"><{$directory.countRepos}>
                            <{if $permGlobalRead && ($directory.dir_autoupdate == 0)}>
                                <a id="btn_update" class="btn btn-primary btn-sm float-right" href="index.php?op=update_dir&amp;dir_name=<{$directory.name}>"><span class="fa fa-refresh fa-lg"></span> <{$smarty.const._MA_WGGITHUB_DIRECTORY_UPDATE}></a>
                            <{/if}>
                    </h4>
                    <p><{$directory.descr}></p>
                </div>
            </div>    
            <hr />
            <div class="d-flex flex-row">
                <div class="bg-secondary text-nowrap mr-2">
                    <!-- Nav tabs for each directory -->
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <{if $directory.previousRepos}>
                            <a id="btn_previous" class="btn btn-outline-warning mx-2 mt-2" href="index.php?op=list<{$directory.previousOp}>&amp;menu=<{$directory.id}>" role="button"><span class="fa fa-arrow-left"></span></a>    
                        <{/if}>
                        <{foreach name=repo item=repo from=$directory.repos}>
                            <a class="mx-2 mt-2 nav-link <{if $smarty.foreach.repo.first}>active<{/if}>" href="#tabdetail<{$repo.id}>" data-toggle="tab"><{$repo.name}></a>
                        <{/foreach}>
                        <{if $directory.nextRepos}>
                            <a id="btn_next" class="btn btn-outline-warning mx-2 mb-2" href="index.php?op=list<{$directory.nextOp}>&amp;menu=<{$directory.id}>" role="button"><span class="fa fa-arrow-right"></span></a>    
                        <{/if}>
                    </div>
                </div>
                <div>
                   <!-- Tab panes -->
                    <div class="tab-content">
                        <{foreach name=repo item=repo from=$directory.repos}>
                            <div class="tab-pane fade <{if $smarty.foreach.repo.first}>active show<{/if}>" id="tabdetail<{$repo.id}>" role="tabpanel">
                                <h4><{$smarty.const._MA_WGGITHUB_REPOSITORY}>: <{$repo.name}></h4>
                                <p>
                                    <span class="fa fa-calendar"></span> <{$repo.createdat}> (<{$smarty.const._MA_WGGITHUB_REPOSITORY_CREATEDAT}>)<br />
                                    <span class="fa fa-calendar"></span> <{$repo.updatedat}> (<{$smarty.const._MA_WGGITHUB_REPOSITORY_UPDATEDAT}>)
                                </p>

                                <{if $repo.releases|default:''}>
                                    <p><b><{$smarty.const._MA_WGGITHUB_RELEASES}>:</b></p>
                                    <{foreach item=release from=$repo.releases}>
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div><{$release.name}><br /><span style="font-size: smaller"><span class="fa fa-calendar"></span> <{$release.publishedat}></span></div>
 
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownButton-ziptar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="fa fa-download fa-lg"></span>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownButton-ziptar">
                                                        <a class="dropdown-item" href="<{$release.zipballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}>"><{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}></a>
                                                        <a class="dropdown-item" href="<{$release.tarballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_TAR}>"><{$smarty.const._MA_WGGITHUB_RELEASE_TAR}></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    <{/foreach}>
                                <{/if}>

                                <p class="pt-2 text-center"><a class="btn btn-primary" href="<{$repo.htmlurl}>" title="<{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}>" target="_blank"><span class="fa fa-github fa-lg"></span> <{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}></a></p>

                                <{if $repo.readme.gitbook_link|default:''}>
                                    <p class="text-center"><a class='btn btn-warning' href="<{$repo.readme.gitbook_link}>" title="<{$smarty.const._MA_WGGITHUB_GITBOOK_GOTO}>" target="_blank"> <span class="fa fa-book fa-lg"></span> <{$smarty.const._MA_WGGITHUB_GITBOOK_GOTO}></a></p>
                                <{/if}>
                                
                                <hr />
                                    <p class="lead mt-2"><span class="fa fa-file-text-o"></span> <b><{$smarty.const._MA_WGGITHUB_REPOSITORY_README}></b>
                                        <{if $permReadmeUpdate|default:''}>
                                            <a class='btn btn-primary btn-sm float-right' href="index.php?op=update_readme&amp;repo_id=<{$repo.id}>&amp;repo_user=<{$repo.user}>&amp;repo_name=<{$repo.name}>" title="<{$smarty.const._MA_WGGITHUB_README_UPDATE}>"><span class="fa fa-refresh fa-lg"></span> <{$smarty.const._MA_WGGITHUB_README_UPDATE}></a>
                                        <{/if}>
                                        <div class="border p-2"><{$repo.readme.content_clean|default:''}></div>
                                    </p>
                            </div>
                        <{/foreach}>
                    </div>
                </div>
            
            </div>
        </div>    
        <{/foreach}>    
            
    </div>
<{/if}>

<script type="text/javascript">
    var executeClick = function(href)
    {
        var tabid = $('.tab-content-main .maintab.active').attr('id');
        var url;
        url = href + '&menu=' + tabid;

        window.location.href=url;
    }
    var toggleFilterRelease = function(display)
    {
        document.getElementById("relfinal").classList.add("disabled");
        document.getElementById("relany").classList.add("disabled");
        <{if $showBtnAll|default:false}>
            document.getElementById("relall").classList.add("disabled");
        <{/if}>

        if (1 == Number(display)) {
            <{if $frelease == 'final'}>
                document.getElementById("relany").classList.remove("disabled");
                <{if $showBtnAll|default:false}>
                    document.getElementById("relall").classList.remove("disabled");
                <{/if}>
            <{/if}>
            <{if $frelease == 'any'}>
                document.getElementById("relfinal").classList.remove("disabled");
                <{if $showBtnAll|default:false}>
                    document.getElementById("relall").classList.remove("disabled");
                <{/if}>
            <{/if}>
            <{if $frelease == 'all'}>
                document.getElementById("relfinal").classList.remove("disabled");
                document.getElementById("relany").classList.remove("disabled");
            <{/if}>
        }
    }
    var toggleFilters = function(display)
    {
        document.getElementById("sortbyname").classList.add("disabled");
        document.getElementById("sortbyupdate").classList.add("disabled");
        if (1 == display) {
            <{if $fsortby == 'name'}>
                document.getElementById("sortbyupdate").classList.remove("disabled");
            <{else}>
                document.getElementById("sortbyname").classList.remove("disabled");
            <{/if}>
        }
    }
</script>

<{include file='db:wggithub_footer.tpl' }>
