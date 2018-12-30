<div class="row">
    <div class="col-md-2 hidden-xs"></div>
    <div class="display col-md-8 col-xs-12">

        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <p class="panel-title">
                    <i class="fa fa-fw fa-{$attributes_map.supanncodeentite.faclass}"></i>
                    {$entry.supanncodeentite.0} - {$entry.description.0}
                </p>
            </div>


            <div class="panel-body">

                <div class="table-responsive">
                <table class="table table-striped table-hover">
                {foreach $card_items as $item}
                {$attribute=$attributes_map.{$item}.attribute}
                {$type=$attributes_map.{$item}.type}
                {$faclass=$attributes_map.{$item}.faclass}

                {if !({$entry.$attribute.0}) && ! $show_undef}
                    {continue}
                {/if}
                    <tr>
                        <th class="text-center">
                            <i class="fa fa-fw fa-{$faclass}"></i>
                        </th>
                        <th class="hidden-xs">
                            {$msg_label_{$item}}
                        </th>
                        <td>
                        {if ({$entry.$attribute.0})}
                            {foreach $entry.{$attribute} as $value}
                            {if $value@index ne 0}
                            	{include 'value_displayer.tpl' value=$value type=$type truncate_value_after=10000}
                            {/if}
                            {/foreach}
                        {else}
                            <i>{$msg_notdefined}</i><br />
                        {/if}
                        </td>
                    </tr>
                {/foreach}
                </table>
                </div>


{if {$show_subentities}}
        <div class="panel panel-info">

            <div class="panel-heading text-center ">
                <p class="panel-title">
                    <i class="fa fa-fw fa-{$attributes_map.supanncodeentite.faclass}"></i>
                    {$msg_supann_entite_daughter}
                </p>
            </div>

<table id="directory-listing" class="table table-striped table-hover table-condensed ">
{include 'listing_table_supannentite.tpl'}
</table>
</div>
{/if}


<!-- show members -->
{if {$show_members}}

{$entries = $member_entries}
{$listing_columns = $listing_columns_member}

        <div class="panel panel-info">

            <div class="panel-heading text-center ">
                <p class="panel-title">
                    <i class="fa fa-fw fa-{$attributes_map.displayname.faclass}"></i>
                    {$msg_supann_entite_members}
                </p>
            </div>

<table id="directory-listing" class="table table-striped table-hover table-condensed">
{include 'listing_table.tpl'}
</table>
</div>
{/if}




    </div>
    <div class="col-md-2 hidden-xs"></div>
</div>
