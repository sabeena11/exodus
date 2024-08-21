<?php

return array (
  'projectName' => 'a2z Loyalty System',
  "createNew" => "Create New",
  "addGift" => "Add Gift",
  "save" => "Save",
  'edit' => 'Edit',
  'delete' => 'Delete',
  "reset" => "Reset",
  "saveandcontinue" => "Save and Continue",
  'cancel' => 'Cancel',
  'remove' => 'Remove',
  'action' => 'Action',
  'add' => 'Add',
  'view' => 'View',
  'update' => 'Update',
  'dragDrop' => 'Drag and drop a file here or click',
  'dragDropReplace' => 'Drag and drop a file or click to replace',
  'pagination' => array (
    'previous' => '&laquo; Previous',
    'next' => 'Next &raquo;',
  ),

  'datatables' => array (
    'emptyTable' => 'No data available in table',
    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
    'infoFiltered' => '(filtered from _MAX_ total entries)',
    'infoPostFix' => '',
    'lengthMenu' => 'Show _MENU_ entries',
    'loadingRecords' => 'Loading...',
    'zeroRecords' => 'No matching records found',
    'paginate' => array (
      'first' => 'First',
      'last' => 'Last',
      'next' => 'Next',
      'previous' => 'Previous',
    ),
    'aria' => array (
      'sortAscending' => ': activate to sort column ascending',
      'sortDescending' => ': activate to sort column descending',
    ),
    'processing' => 'Processing...',
    'search' => 'Search:',
    'infoThousands' => ',',
  ),
 
  'messages' => array (
    'passwordlength'=>'(Length: minimum 6 Character)',
    'passwordNote' => '(Leave blank to keep current password)',
    'imageNote'  =>'(Accept jpg, jpeg and png image type)',
    'deleteWarning' => 'You will not be able to recover the deleted record!',
    'areYouSure' => 'Are you sure?',
    'defaultRoleCantDelete' => 'Default role can not be deleted.',
    'noRoleMemberFound' => 'No member is assigned to this role.',
    'roleAssigned' => 'Roles assigned successfully.',
    'createdSuccessfully' => 'created successfully.',
    'recordDeleted' => 'Record deleted successfully.',
    'updatedSuccessfully' => 'Updated successfully.',
  ),
  'menus' => array (
    'title'=>'Title',
    'link'=>'Link',
    'position'=>'Position',
    'section'=>'Section',
  ),

  'user' => array (
    'name' => 'Name',
    'email' => 'Email',
    'roleName' => 'Role',
    'password' => 'Password',
    'mobile' => 'Mobile',
    'image' => 'Image',
    'verified' => 'Verified',
    'notVerified' => 'Not Verified',
    'is_superuser' => 'Is Superuser',
    'sex' => 'Sex',
    'point' => 'Point',
    'address' => 'Address',
    'dob' => 'Date of Birth',
    'is_staff' => 'Is Staff',
    'is_verified' => 'Is Verified',
    'fcm' => 'Fcm',
    'branch' => 'Branch',
    'last_login' => 'Last Login'
  ),

  'userwisereports' => array (
    'user' => 'User',
    'categories' => 'Category',
    'created' => 'Date',
    'points' => 'Points',
    'desc' => 'Description',
    'branch' => 'Branch',
  ),
  
  'giftwisereports' => array (
    'user' => 'User',
    'categories' => 'Category',
    'created' => 'Date',
    'points' => 'Points',
    'desc' => 'Description',
    'branch' => 'Branch',
  ),

  'branch' => array (
    'name' => 'Name',
    'unique_id' => 'Unique ID',
    'paired' => 'Paired',
    'address' =>'Address',
    'contact_person' => 'Contact Person',
    'phone' => 'Phone',
    'desc' => 'Desc',
    'image' => 'Image',
    'email' => 'Email',
    'verified' => 'Verified',
    'notVerified' => 'Not Verified',
  ),


  'product' => array (
    'image' => 'Image',
    'name' => 'Product Name',
    'price' => 'Price',
    'discount' => 'Discount',
    'category' => 'Sub Category',
    'desc' => 'Description',
  ), 

  'subcategory' => array (
  
    'name' => 'Name',
    'image' => 'Image',
    'category' => 'Category',
  ),
  
  'category' => array (
    'image' => 'Image',
    'name' => 'Name',
  ),
  'banners' => array (
    'image' => 'Banner',
    'title' => 'Title',
    'views' => 'Views',
    'priority' => 'Priority',
    'created' => 'Created',
    'url' => 'Url',
    'desc' => 'Description',
    'isactive' => 'Is active',
    

  ),

  'sliders' => array (
    'image' => 'Image',
    'title' => 'Title',
    'desc' => 'Description',
   
    

  ),
  
  'slidercards' => array (

    'title' => 'Title',
    'icon' => 'Icon',
    'desc' => 'Description',
   
  ),

   'overviews' => array (
  
    'desc' => 'Description',
   
  ),
  'features' => array (
      'icon' => 'Icon',
      'title' => 'Title',
    
  ),

  'gifts' => array (
    'user' => 'User',
    'categories' => 'Category',
    'created' => 'Date',
    'points' => 'Points',
    'desc' => 'Description',
    'branch' => 'Branch',
  ),

  'coupon' => array (
    'point' => 'Point',
    'title' => 'Title',
    'desc' => 'Description',
    'banner' => 'Banner',
    'startdate' => 'Start Date',
    'enddate' => 'End Date',
    'image' => 'Image',
  ),

  'couponuse' => array (
    'coupon' => 'Coupon',
    'user' => 'User',
    'created' => 'Created',
  ),

  'clientsoverview' => array (
    'desc' => 'Description',
    'name' => 'Name',
    'designation' => 'Designation',
    'rating_star' => 'Rating Star',
    'image' =>'Image'
  ),
  
  'purchases' => array (
    'user_id' => 'User',
    'purchase_id' => 'Purchase ID',
    'master_id' => 'Master ID',
    'points' => 'Point',
    'date' => 'Date',
    'bill_no' => 'Bill No',
    'branch_id' => 'Branch',
    'end_device_id' => 'End Device',
    'total' => 'Total Amount',
    'gross_amount' => 'Gross Amount',
    'discount' => 'Discount',
  ),
  'purchaseitem' => array (
    'itemname' => 'Item Name',
    'itemprice' => 'Item Price',
    'quantity' => 'Quantity',
    'purchase_id' => 'Purchase',
  ),
  'smslogs' => array (
    'user' => 'User',
    'success' => 'Success',
    'message' => 'Message',
    'response' => 'Response',
    'created' => 'Created',
    'status' => 'Status'
  ),
  
  'updatelogs' => array (
    'created' => 'Created',
    'enddevice' => 'End Device',
    'data' => 'Details',
  ),

  'eventlogs' => array (
     'user_id' => 'User',
    'title' => 'Title',
    'desc' => 'Description',
    'image' => 'Image',
    'created' => 'Created',   
  ),
  'roles' => array (
    'addRole' => 'Manage Role',
  ),

  'permission' => array (
    'projectNote' => 'User can view the basic details of projects assigned to him even without any permission.',
    'attendanceNote' => 'User can view his own attendance even without any permission.',
    'taskNote' => 'User can view the tasks assigned to him even without any permission.',
    'ticketNote' => 'User can view the tickets generated by him as default even without any permission.',
    'eventNote' => 'User can view the events to be attended by him as default even without any permission.',
    'selectAll' => 'Select All',
    'addRoleMember' => 'Manage Role Members',
    'addMembers' => 'Add Members',
    'roleName' => 'Role Name',
  ),
  'myProfile' => array (
    'name' => 'Name',
    'email' => 'Email',
    'roleName' => 'Role',
    'password' => 'Password',
    'mobile' => 'Mobile',
    'image' => 'Image',
    'verified' => 'Verified',
    'notVerified' => 'Not Verified',
  ),

  'companySettings' => array (
    'companyName' => 'Company Name',
    'companyEmail' => 'Company Email',
    'companyPhone' => 'Company Phone',
    'companyWebsite' => 'Company Website',
    'companyLogo' => 'Company Logo',
    'companyAddress' => 'Company Address',
    'facebookUrl' => 'Facebook',
    'linkedinUrl' => 'Linked In',
    'instagramUrl' => 'Instagram',
    'twitterUrl' => 'Twitter',
  ),
  
  'appConfigs' => array (
    'rewardValue' => 'Reward Value',
    'smsToken' => 'Sms Token',
    'enableSms' => 'Enable Sms',
    'enableNotification' => 'Enable Notification',
  ),
  'feedBacks' => array (
    'details' => 'Details',
    'created' => 'Created',
    'user_id' => 'User Id',
    'status' => 'Status',
  ),
  'endDevices' => array (
    'created' => 'Created',
    'unique_id' => 'Unique ID',
    'paired' => 'Paired',
    'branch_id' => 'Branch ID',
    'desc' => 'Description',
  )
);
