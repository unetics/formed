<ul id='well' class='accordion'>
<div ng-repeat="el in build"
     style='position: relative; margin: 0'
     id='edit_{{$index}}'
     class='nform_edit_div'>
    <ul>
        <li id='{{$index}}'
            class='accordion-group'>
            <div class="accordion-heading"
                 style='height: 38px'>
                <div class="edit_head"
                     href="#collapse{{$index}}"
                     compile="el.el_b"
                     id='acc{{$index}}'
                     data-parent='#well_accordion'></div><button class='del-btn'
                     id='db_{{$index}}'
                     ng-click='remEl($index)'
                     title='Delete Field'
                     ng-disabled="el.isDisabled">
                <div class="dashicons dashicons-trash"></div></button>
            </div>
            <div id="collapse{{$index}}"
                 class="accordion-body">
                <div class="accordion-inner"
                     compile="el.el_b2"></div>
            </div>
        </li>
    </ul>
</div>
</ul>