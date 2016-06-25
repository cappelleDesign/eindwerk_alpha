<?php
$mail = $this->getCurrentUser() ? $this->getCurrentUser()->getEmail() : '';
global $formData;
global $fieldName;
global $extraMsg;
$formData = isset($_POST['contact-feedback']) ? $_POST['contact-feedback'] : NULL;
$qType = '';
if ($formData) {
    $qType = $formData['contactQTypeState']['prevVal'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $this->includeHeader();
        ?>        
        <title>Contact</title>
    </head>
    <body>
        <div id="wrapper">
            <?php
            $page = 'contact.php';
            $this->includeMenu($page);
            ?>            
            <main role="main" class="content container-fluid">
                <div class="row">                    
                    <form role="form" id="contact-form" class="col-md-8 col-md-offset-2 neo-form" action="contact/sendmail" method="POST">     
                        <fieldset class="">
                            <legend class="text-center">Send us an email</legend>
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
                            <div class="form-group has-feedback <?php echo $formData ? $formData['contactQTypeState']['errorClass'] : '' ?>">
                                <label for="contact-subject">
                                    Subject:
                                </label>
                                <select autofocus class="form-control validation" id="contact-subject" 
                                        name="contact-subject" required
                                        data-validation="req" data-addon="false">               
                                    <option value="">
                                        -- Select a subject
                                    </option>
                                    <option value="suggestion@neoludus.com" <?php echo $qType == 'suggestion@neoludus.com' ? 'selected' : ''; ?>>
                                        Suggestion
                                    </option>
                                    <option value="info@neoludus.com" <?php echo $qType == 'info@neoludus.com' ? 'selected' : ''; ?>>
                                        General Question
                                    </option>                                
                                </select>

                            </div>
                            <div class="form-group has-feedback <?php echo $formData ? $formData['contactMailState']['errorClass'] : '' ?>">
                                <label for="contact-mail">
                                    Your email:
                                </label>
                                <input type="text" class="validation form-control" 
                                       id="contact-mail" data-validation="mail" data-addon="false"
                                       name="contact-mail" value="<?php echo $formData ? $formData['contactMailState']['prevVal'] : $mail ?>"
                                       placeholder="Fill in your mail here">                     
                                       <?php
                                       $fieldName = 'contactMailState';
                                       $this->includeFormFeedback();
                                       ?>
                            </div>
                            <div class="form-group has-feedback <?php echo $formData ? $formData['contactBodyState']['errorClass'] : '' ?>">
                                <label for="contact-body">
                                    Your message:
                                </label>    
                                <textarea rows="5" required placeholder="Your message goes here" 
                                          class="form-control validation" name="contact-body"
                                          data-validation="req" data-addon="false" id="contact-body"><?php
                                              echo $formData ? $formData['contactBodyState']['prevVal'] : '';
                                              ?></textarea>
                                <?php
                                $fieldName = 'contactBodyState';
                                $this->includeFormFeedback();
                                ?>
                            </div>
                        </fieldset>  
                        <span class="row" style="margin: 0;">                            
                            <button disabled type="submit" id="formSubmit" 
                                    class="btn neo-btn submit-disabled col-xs-4 col-xs-offset-8"
                                    data-toggle="contact-submit-tooltip" data-placement="bottom" title="Fill in the form first!">
                                Send
                            </button>                        
                        </span>
                    </form>                   
                </div>
            </main>
        </div>
        <footer>
            <?php $this->includeFooter();
            ?>
        </footer>

        <?php
        $this->includeScripts();
        ?> 
        <script>

        </script>
    </body>
</html>
