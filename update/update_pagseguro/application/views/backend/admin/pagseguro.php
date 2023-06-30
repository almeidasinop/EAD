<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('pagseguro_history'); ?>  </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card widget-inline">
            <div class="card-body p-0">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xl-4">
                        <a href="<?php echo site_url('admin/pagseguro'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="dripicons-thumbs-up text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $status_wise_transactions['concluido']->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('pagseguro_ok'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <a href="<?php echo site_url('admin/pagseguro'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-clockwise text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $status_wise_transactions['aguardando']->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('pagseguro_aguardando'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <a href="<?php echo site_url('admin/pagseguro'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-wrong text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $status_wise_transactions['cancelado']->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('pagseguro_cancelado'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>


                </div> <!-- end row -->
            </div>
        </div> <!-- end card-box-->
    </div> <!-- end col-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('pagseguro_list'); ?></h4>
                <form class="row justify-content-center" action="<?php echo site_url('admin/pagseguro'); ?>" method="get">

                <!-- Course Status -->
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="status"><?php echo get_phrase('status'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
                            <option value="all" <?php if($selected_status == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                            <option value="1" <?php if($selected_status == '1') echo 'selected'; ?>><?php echo get_phrase('pagseguro_aguardando1'); ?></option>
                            <option value="3" <?php if($selected_status == '3') echo 'selected'; ?>><?php echo get_phrase('pagseguro_ok1'); ?></option>
                            <option value="7" <?php if($selected_status == '7') echo 'selected'; ?>><?php echo get_phrase('pagseguro_cancelado1'); ?></option>
                        </select>
                    </div>
                </div>

                <!-- Course Instructors -->
                <div class="col-xl-4">
                    <div class="form-group">
                        <label for="id_courses"><?php echo get_phrase('course'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="id_courses" id="id_courses">
                            <option value="<?php echo 'all'; ?>" <?php if($selected_id_courses == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                <?php foreach ($courses->result_array() as $course): ?>
                                        <option value="<?php echo $course['id']; ?>" <?php if($selected_id_courses == $course['id']) echo 'selected'; ?>><?php echo $course['title']; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Course User -->
                <div class="col-xl-3">
                    <div class="form-group">
                        <label for="id_user"><?php echo get_phrase('user'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="id_user" id = 'id_user'>
                            <option value="all" <?php if($selected_id_user == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                            <?php foreach ($id_user as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php if($selected_id_user == $user['id']) echo 'selected'; ?>><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <div class="col-xl-2">
                    <label for=".." class="text-white">..</label>
                    <button type="submit" class="btn btn-primary btn-block" name="button"><?php echo get_phrase('filter'); ?></button>
                </div>
            </form>

            <div class="table-responsive-sm mt-4">
                <?php if (count($transactions) > 0): ?>
                    <table id="course-datatable" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase('user'); ?></th>
                                <th><?php echo get_phrase('courses'); ?></th>
                                <th><?php echo get_phrase('total_amount'); ?></th>
                                <th><?php echo get_phrase('status'); ?></th>
                                <th><?php echo get_phrase('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $key => $transaction):
                                
                                $user_details = $this->user_model->get_all_user($transaction['id_user'])->row_array();
                            ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <strong><?php echo $user_details['first_name'] . '&nbsp;' . $user_details['last_name']; ?></strong><br>
                                    </td>
                                    <td>
                                       <?php $array_courses = explode(":", $transaction['id_courses']);
                                        $count = "0";
                                         for ($i=0;$i<sizeof($array_courses);$i++) {
                                             $count++;
                                             $course_details = $this->crud_model->get_course_by_id($array_courses[$i])->row_array();
                                        ?>
                                        <small class="text-muted"><?php echo '<b>'.$course_details['id'].'</b> - '.$course_details['title']; ?></small><br>
                                        <?php } ?>
                                    </td>
                                    <td>
                                            <span class="badge badge-<?php if ($transaction['status'] == '1') { echo 'danger'; } elseif ($transaction['status'] == '3') { echo 'success'; } else echo 'dark'; ?>-lighten"><?php echo currency($transaction['amount']); ?></span>

                                    </td>
                                    <td>
                                        <?php if ($transaction['status'] == '1'): ?>
                                            <span class="badge badge-danger-lighten"><?php echo get_phrase('pagseguro_aguardando1'); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($transaction['status'] == '3'): ?>
                                            <span class="badge badge-success-lighten"><?php echo get_phrase('pagseguro_concluido1'); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($transaction['status'] == '7'): ?>
                                            <span class="badge badge-dark-lighten"><?php echo get_phrase('pagseguro_cancelado1'); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <div class="dropright dropright">
                                          <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="mdi mdi-dots-vertical"></i>
                                          </button>
                                          <ul class="dropdown-menu">
                                              <li>
                                                  <?php if ($transaction['status'] == '1'): ?>
                                                      <?php if ($transaction['id_user'] != $this->session->userdata('user_id')): ?>
                                                          <a class="dropdown-item" href="#" onclick="showAjaxModal('#', '<?php echo get_phrase('mark_as_paid'); ?>');">
                                                              <?php echo get_phrase('mark_as_paid');?>
                                                          </a>
                                                      <?php else: ?>
                                                          <a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url();?>admin/change_course_status_for_admin/pending/<?php echo $transaction['id']; ?>/<?php echo $selected_id_user; ?>/<?php echo $selected_status;?>', '<?php echo get_phrase('inform_instructor'); ?>');">
                                                              <?php echo get_phrase('mark_as_paid');?>
                                                          </a>
                                                      <?php endif; ?>
                                                  <?php else: ?>
                                                      <?php if ($transaction['id_user'] != $this->session->userdata('user_id')): ?>
                                                          <a class="dropdown-item" href="#" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/mail_on_course_status_changing_modal/active/<?php echo $transaction['id']; ?>/<?php echo $selected_id_user; ?>/<?php echo $selected_status;?>', '<?php echo get_phrase('inform_instructor'); ?>');">
                                                              <?php echo get_phrase('mark_as_active');?>
                                                          </a>
                                                      <?php else: ?>
                                                          <a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url();?>admin/change_course_status_for_admin/active/<?php echo $transaction['id']; ?>/<?php echo $selected_id_user; ?>/<?php echo $selected_status;?>', '<?php echo get_phrase('inform_instructor'); ?>');">
                                                              <?php echo get_phrase('mark_as_active');?>
                                                          </a>
                                                      <?php endif; ?>
                                                  <?php endif; ?>
                                              </li>
                                              <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/course_actions/delete/'.$transaction['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                          </ul>
                                      </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <?php if (count($transactions) == 0): ?>
                    <div class="img-fluid w-100 text-center">
                      <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
                      <?php echo get_phrase('no_data_found'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
