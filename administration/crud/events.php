<?php

Libraries_Event::registerEventHandler('beforeCrudSave', 'Crud_Events_Events', 'orderIndexBeforeSaveEvent');
Libraries_Event::registerEventHandler('afterCrudSave', 'Crud_Events_Events', 'logActionAfterSave');