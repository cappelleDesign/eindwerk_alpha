<?php
$formData = isset($_POST['avatar-feedback']) ? $_POST['avatar-feedback'] : NULL;
$tier = '';
if ($formData) {
    $tier = $formData['avatarTierState']['prevVal'];
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Neoludus admin - Dashboard</title>
        <?php $this->includeHeader(); ?>
        <?php $this->includeAdminHeader(); ?>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php $this->includeAdminMenu('avatar-mgr'); ?>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Avatar manager</h1>
                            <div class="container-fluid">
                                <div class="row"> 
                                    <form role="form" id="avatar-form" class="col-md-8 col-md-offset-2" action="admin/addAvatar" method="POST" enctype="multipart/form-data">     
                                        <fieldset class="">
                                            <legend class="text-center">Add a new avatar</legend>
                                            <?php
                                            $extraMsg = isset($formData['extraMessage']) ? $formData['extraMessage'] : '';
                                            $this->includeFormFeedback(TRUE)
                                            ?>                                
                                            <div class="form-group form-filter hidden">
                                                <label for="input-filter">Not to be filled in</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-ban"></i></span>
                                                    <input value="" type="text" class="form-control" id="input-filter" name="input-filter" placeholder="Are you a robot?">
                                                </div>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['avatarTier']['errorClass'] : '' ?>">
                                                <label for="avatar-tier">
                                                    Tier:
                                                </label>
                                                <select autofocus class="form-control validation" id="avatar-tier" 
                                                        name="avatar-tier" required
                                                        data-validation="req" data-addon="false">               
                                                    <option value="">
                                                        -- Select a tier
                                                    </option>
                                                    <option value="1" <?php echo $tier == '1' ? 'selected' : ''; ?>>
                                                        Tier 1
                                                    </option>
                                                    <option value="2" <?php echo $tier == '2' ? 'selected' : ''; ?>>
                                                        Tier 2
                                                    </option>
                                                    <option value="3" <?php echo $tier == '3' ? 'selected' : ''; ?>>
                                                        Tier 3
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['avatarAlt']['errorClass'] : '' ?>">
                                                <label for="avatar-alt">
                                                    Description:
                                                </label>
                                                <input type="text" class="validation form-control" 
                                                       id="avatar-alt" data-validation="req" data-addon="false"
                                                       name="avatar-alt" value="<?php echo $formData ? $formData['avatarAlt']['prevVal'] : '' ?>"
                                                       placeholder="Descript the image here">                     
                                                       <?php
                                                       $fieldName = 'avatarAlt';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>
                                            <div class="form-group has-feedback <?php echo $formData ? $formData['avatarImg']['errorClass'] : '' ?>">
                                                <label for="avatar-img">
                                                    Picture:
                                                </label>
                                                <input type="file" class="validation form-control" 
                                                       id="avatar-img" data-validation="req" data-addon="false"
                                                       name="avatar-img">                     
                                                       <?php
                                                       $fieldName = 'avatarImg';
                                                       $this->includeFormFeedback();
                                                       ?>
                                            </div>
                                        </fieldset>  
                                        <span class="row" style="margin: 0;">                            
                                            <button disabled type="submit" id="formSubmit" 
                                                    class="btn btn-success submit-disabled col-xs-4 col-xs-offset-8"
                                                    data-toggle="contact-submit-tooltip" data-placement="bottom" title="Fill in the form first!">
                                                Add
                                            </button>                        
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>                        
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <?php $this->includeScripts(); ?>
        <?php $this->includeAdminScripts(); ?>
    </body>

</html>
