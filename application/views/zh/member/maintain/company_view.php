<div class="form-body">
    <div class="form-group">
        <div class="col-md-6">
            <div class="control-label col-md-3">會員名稱：</div>
            <div class="control-label col-md-9 textLeft">
                <?php echo $member["member_name"]; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-label col-md-3">會員身分證：</div>
            <div class="control-label col-md-9 textLeft">
                <?php echo $member["member_identify"]; ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <div class="control-label col-md-3">會員手機：</div>
            <div class="control-label col-md-9 textLeft">
                <?php echo $member["member_phone"]; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-label col-md-3">生日：</div>
            <div class="control-label col-md-9 textLeft">
                <?php echo $member["member_birthday"]; ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label class="control-label col-md-3">Email：</label>
            <?php if(is_null($member["member_email"]) || empty($member["member_email"])): ?>
                <div class="col-md-9">
                    <div class="input-icon">
                        <i class="fa icon-envelope"></i>
                        <input type="text" placeholder="請填入聯絡 email" class="form-control" name="member_email" />
                    </div>
                </div>
            <?php else: ?>
                <div class="control-label col-md-9 textLeft">
                    <?php echo $member["member_email"]; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label class="control-label col-md-3">會員英文姓名：</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="請填入英文姓名" class="form-control" name="member_en_name" value="<?php echo $member['member_en_name']; ?>" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label class="control-label col-md-3">電話：</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <i class="fa fa-phone"></i>
                    <input type="text" placeholder="請填入聯絡電話" class="form-control" name="member_tel" value="<?php echo (!is_null($member["member_tel"]) ? $member["member_tel"]:""); ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label col-md-3">地址：</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <i class="fa fa-map-pin"></i>
                    <input type="text" placeholder="請填入聯絡地址" class="form-control" name="member_address" value="<?php echo (!is_null($member["member_address"]) ? $member["member_address"]:""); ?>" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <label class="control-label col-md-3">身分證發(換)證地點：</label>
            <div class="col-md-9">
                <div class="input-icon merchant_address">
                    <select class="form-control city" name="id_card_place" data-city="<?php echo (!empty($member) ? $member["id_card_place"]:""); ?>">
                        <option value="0">請選擇縣市</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label col-md-3">身分證發(換)證日期：</label>
            <div class="col-md-9">
                <div class="input-icon">
                    <i class="fa fa-calendar-check-o"></i>
                    <input type="text" placeholder="請填入身分證發(換)證日期" class="form-control date-picker" name="id_card_date" value="<?php echo (!is_null($member["id_card_date"]) ? $member["id_card_date"]:""); ?>" data-date="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd" />
                </div>
            </div>
        </div>
    </div>
</div>