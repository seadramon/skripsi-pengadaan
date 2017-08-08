
<div class="col-md-9">

    <div class="thumbnail">
        <div class="caption-full">
            <?php 
            if (is_array($error_msg) && count($error_msg) > 0) {
                foreach ($error_msg as $row) {
                    foreach ($row as $val) {
                        echo $val;
                    }
                }
            }
            ?>
            <h3>Create User Organisasi</h3>
            <hr>
            <form action="{action}" method="post">
                {post}
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama" value="{nama}" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{email}" />
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <?php echo form_dropdown('role', $role, array_key_exists('role', $post[0])?$post[0]['role']:"", 'class="form-control" id="role"'); ?>
                </div>
                {/post}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{cancel_btn}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</div>

