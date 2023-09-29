<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas fa-project-diagram fs-3" aria-hidden="true"></i>
        </span>
        <span class="menu-title">Project Data</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('MgtProjects'), $label = 'Projects');
        
        MenuItem($link = route('ModuleSelectProject'), $label = 'Project Modules');
        
        MenuItem($link = route('SelectActivityProject'), $label = 'Project Activities');
        
        MenuItem($link = route('MgtExpenditureCategories'), $label = 'Expenditure Categories');
        
        MenuItem($link = route('ExpenditureSelectProject'), $label = 'Project Expenditure');
        
        // MenuItem($link = route('SelectActivityProject'), $label = 'Activity Progress Status');
        
        ?>


    </div>
</div>

<div data-kt-menu-trigger="click" class="menu-item menu-accordion ">
    <span class="menu-link">
        <span class="menu-icon">
            <i class="fas fa-chart-area fs-3" aria-hidden="true"></i>
        </span>
        <span class="menu-title">Analytics</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">

        <?php
        
        MenuItem($link = route('GeneralDashboard'), $label = 'General Analytics');
        MenuItem($link = route('ModuleExpenditureYear'), $label = 'Module Performance');
        MenuItem($link = route('TechSelectActivityProject'), $label = 'Activity Progress Settings');
        MenuItem($link = route('FinRepProject'), $label = 'Financial  Report');
        
        // MenuItem($link = route('MgtProjects'), $label = 'Cost Input Analytics');
        // MenuItem($link = route('MgtProjects'), $label = 'Cost Input Grouping');
        // MenuItem($link = route('MgtProjects'), $label = 'Cost Input Grouping');
        
        ?>


    </div>
</div>
