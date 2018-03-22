package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.view.Gravity;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.config.ConfigValue;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.presenter.ChangeUserInfoPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.ChangeUserInfoView;
import com.jsyh.shopping.uilibrary.dialog.DataTimePickerDialog;
import com.jsyh.shopping.uilibrary.popuwindow.SelectPhotoPopupwindow;
import com.jsyh.shopping.uilibrary.uiutils.ImageUtils;

import java.io.File;
import java.util.Calendar;

/**
 * Created by sks on 2015/9/16.
 * 我的账户
 */
public class MeAccountActivity extends BaseActivity implements View.OnClickListener,
        ChangeUserInfoView {
    private Context context;
    TextView title;
    ImageView back;
    private TextView ensure;
    private ImageView avatar;
    private SelectPhotoPopupwindow photoPopupwindow;
    private View parentView;
    public final static int PHOTO_GRAPH = 1;// 拍照
    public final static int SELECT_PICTURE = 0;// 相册选择
    public final static int SAVE_PHOTO = 2;
    public static final int INTENT_MAN = 100;//男
    public static final int INTENT_WOMAN = 101;//女
    public static final int INTENT_PRIVACY = 102;//保密
    public static final int INTENT_NICKNAME = 103;//昵称
    public static String filePath = "";
    private TextView txtUserName, txtNickname, txtSex, txtBirthday;
    private ChangeUserInfoPresenter changeUserInfoPresenter;
    private String birthday;
    private int sex;

    private Uri imageUri;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }

    @Override
    public void initView() {
        setContentView(R.layout.acitivity_meaccout);
        context = this;
        changeUserInfoPresenter = new ChangeUserInfoPresenter(this);
        title = (TextView) findViewById(R.id.title);
        back = (ImageView) findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        ensure = (TextView) findViewById(R.id.ensure);
        ensure.setText("提交");
        title.setText("我的账户");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        findViewById(R.id.right).setOnClickListener(this);
        parentView = findViewById(R.id.lineLayMain);
        photoPopupwindow = new SelectPhotoPopupwindow(context, this);
        avatar = (ImageView) findViewById(R.id.imgAvatar);
        txtUserName = (TextView) findViewById(R.id.txtUserName);
        txtNickname = (TextView) findViewById(R.id.txtNickname);
        txtSex = (TextView) findViewById(R.id.txtSex);
        txtBirthday = (TextView) findViewById(R.id.txtBirthday);
        findViewById(R.id.rlAvatr).setOnClickListener(this);
        findViewById(R.id.rlUserName).setOnClickListener(this);
//        findViewById(R.id.rlAlias).setOnClickListener(this);
        findViewById(R.id.rlSex).setOnClickListener(this);
        findViewById(R.id.rlBirthday).setOnClickListener(this);
        findViewById(R.id.rlChangePassword).setOnClickListener(this);
        showData();
    }

    //图片保存在本地，查看本地有无头像，若有则显示，没有则不显示

    private void initHeadPhoto() {
        String filePath = ConfigValue.HEAD_PHOTO_DIR + File.separator + ConfigValue.uInfor.getNick_name() + ".jpg";
        File file = new File(filePath);
        if (file.exists()) {
            Bitmap bitmap = ImageUtils.compressBitmap(filePath, 320, 320);
            if (bitmap != null) {
                avatar.setImageBitmap(bitmap);
            }
        }
    }

    private void showData() {
        txtUserName.setText(ConfigValue.uInfor.getNick_name());
        txtNickname.setText(ConfigValue.uInfor.getEmail());
        sex = Integer.parseInt(ConfigValue.uInfor.getSex());
        switch (sex) {
            case 0:
                txtSex.setText("男");
                break;
            case 1:
                txtSex.setText("女");
                break;
            case 2:
                txtSex.setText("保密");
                break;
        }
        String b = ConfigValue.uInfor.getBirthday();
        if (b.equals("") || b.contains("0000")) {
            Calendar calendar = Calendar.getInstance();
            b = calendar.get(Calendar.YEAR) + "年"
                    + calendar.get(Calendar.MONTH) + 1 + "月"
                    + calendar.get(Calendar.DAY_OF_MONTH) + "日";
            txtBirthday.setText(b);
        } else {
            String[] strings = b.split("-");
            b = strings[0] + "年" + strings[1] + "月" + strings[2] + "日";
            txtBirthday.setText(b);
        }
        initHeadPhoto();
    }

    //相机拍照获取图片
    private void takepictures() {
        String state = Environment.getExternalStorageState();
        if (state.equals(Environment.MEDIA_MOUNTED)) {
            File dir = new File("/sdcard/onlineshopping/avatar/");
            if (!dir.exists()) {
                dir.mkdirs();
            }
            File file = new File(dir, "newhead.jpg");
            filePath = file.getAbsolutePath();
            imageUri = Uri.fromFile(file);
            Intent intent = new Intent(
                    MediaStore.ACTION_IMAGE_CAPTURE);
            intent.putExtra(MediaStore.EXTRA_OUTPUT, imageUri);
            startActivityForResult(intent, PHOTO_GRAPH);
        } else
            Toast.makeText(context, "未插入SD卡", Toast.LENGTH_SHORT).show();
    }

    private void cardSelect() {
        Intent it = new Intent(Intent.ACTION_GET_CONTENT);
        it.setType("image/*");
        File dir = new File("/sdcard/onlineshopping/avatar/");
        if (!dir.exists()) {
            dir.mkdirs();
        }
        File file = new File(dir, "newhead.jpg");
        imageUri = Uri.fromFile(file);

        startActivityForResult(it, SELECT_PICTURE);
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (resultCode != RESULT_OK) {
            switch (resultCode) {
                case MeAccountActivity.INTENT_MAN:
                    sex = 0;
                    txtSex.setText("男");
                    break;
                case MeAccountActivity.INTENT_WOMAN:
                    sex = 1;
                    txtSex.setText("女");
                    break;
                case MeAccountActivity.INTENT_PRIVACY:
                    sex = 2;
                    txtSex.setText("保密");
                    break;
                case MeAccountActivity.INTENT_NICKNAME:
                    Bundle b = data.getExtras();
                    txtNickname.setText(b.getString("nickname"));
                    break;
            }
        } else {
            switch (requestCode) {
                case MeAccountActivity.PHOTO_GRAPH:
                    /*Bitmap bitmap = BitmapUtil.compressBitmap(filePath, 0, 0);
                    Uri uri = Uri.parse(MediaStore.Images.Media.insertImage(
                            getContentResolver(), bitmap, null, null));*/
                    startImageAction(imageUri, 320, 320,
                            SAVE_PHOTO, true);
                    break;
                case MeAccountActivity.SELECT_PICTURE:
                    Uri uri1 = null;
                    if (data == null) {
                        return;
                    }
                    //imageUri = data.getData();
                    // startPhotoZoom(imageUri);
                    uri1 = data.getData();
                    startImageAction(uri1, 320, 320,
                            SAVE_PHOTO, true);
                    break;
                case MeAccountActivity.SAVE_PHOTO:
                    if (data == null)
                        return;
                    else
                        showPhoto(data);
                    filePath = "";
                    break;
            }
        }
        super.onActivityResult(requestCode, resultCode, data);
    }

    /**
     * 剪裁照片，并将剪裁之后的照片存在imageUri中，照片的名称问newhead.jpg,若提交更改，则将newhead.jpg重命名为head.jpg
     *
     * @param uri
     * @param outputX
     * @param outputY
     * @param requestCode
     * @param isCrop
     */
    private void startImageAction(Uri uri, int outputX, int outputY,
                                  int requestCode, boolean isCrop) {
        Intent intent = null;
        if (isCrop) {
            intent = new Intent("com.android.camera.action.CROP");
        } else {
            intent = new Intent(Intent.ACTION_GET_CONTENT, null);
        }
        intent.setDataAndType(uri, "image/*");
        intent.putExtra("crop", "true");
        intent.putExtra("aspectX", 1);
        intent.putExtra("aspectY", 1);
        intent.putExtra("outputX", outputX);
        intent.putExtra("outputY", outputY);
        intent.putExtra("scale", true);
        intent.putExtra(MediaStore.EXTRA_OUTPUT, imageUri);
        intent.putExtra("return-data", true);
        intent.putExtra("outputFormat", Bitmap.CompressFormat.JPEG.toString());
        intent.putExtra("noFaceDetection", true); // no face detection
        startActivityForResult(intent, requestCode);
    }

    public void startPhotoZoom(Uri uri) {

        Intent intent = new Intent("com.android.camera.action.CROP");
        intent.setDataAndType(uri, "image/*");
        // 设置裁剪
        intent.putExtra("crop", "true");
        // aspectX aspectY 是宽高的比例
        intent.putExtra("aspectX", 1);
        intent.putExtra("aspectY", 1);
        // outputX outputY 是裁剪图片宽高
        intent.putExtra("outputX", 320);
        intent.putExtra("outputY", 320);
        intent.putExtra("return-data", true);
        startActivityForResult(intent, SAVE_PHOTO);
    }

    private void showPhoto(Intent data) {
        Bundle extras = data.getExtras();
        if (extras != null) {
            Bitmap bitmap = extras.getParcelable("data");
            if (bitmap != null) {
                avatar.setImageBitmap(bitmap);
                if (bitmap != null && bitmap.isRecycled()) {
                    bitmap.recycle();
                }
            }
        }
    }

    private void getInfo() {
        birthday = txtBirthday.getText().toString();
        birthday = birthday.replace("年", "-");
        birthday = birthday.replace("月", "-");
        birthday = birthday.replace("日", "");
        /**
         * 头像保存在本地,newhead.jpg重命名为userId.jpg
         */
        File file = new File("/sdcard/onlineshopping/avatar/newhead.jpg");
        if (file.exists()) {
            file.renameTo(new File("/sdcard/onlineshopping/avatar/" + ConfigValue.uInfor.getNick_name() + ".jpg"));
        }
        changeUserInfoPresenter.getUserInfo(context, String.valueOf(sex), birthday);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.fl_Left:
                finish();
                break;
            case R.id.right:
                getInfo();
                break;
            case R.id.rlAvatr:
                photoPopupwindow.showAtLocation(parentView, Gravity.BOTTOM | Gravity.CENTER_HORIZONTAL, 0, 0);
                break;
            //拍照
            case R.id.btn_take_photo:
                photoPopupwindow.dismiss();
                takepictures();
                break;
            //相册
            case R.id.btn_pick_photo:
                photoPopupwindow.dismiss();
                cardSelect();
                break;
            //昵称
//            case R.id.rlAlias:
//                Intent itNickname = new Intent(context,NicknameActivity.class);
//                startActivityForResult(itNickname, 1);
//                break;
            //性别
            case R.id.rlSex:
                Intent itSex = new Intent(context, SexChangeActivity.class);
                startActivityForResult(itSex, 1);
                break;
            //出生年月
            case R.id.rlBirthday:
                DataTimePickerDialog dialog = new DataTimePickerDialog(
                        MeAccountActivity.this, txtBirthday.getText().toString());
                dialog.dateTimePicKDialog(txtBirthday);
                break;
            //修改密码
            case R.id.rlChangePassword:
                Intent intent = new Intent(context, ChangePasswordActivity.class);
                startActivity(intent);
                break;
        }
    }

    @Override
    public void result(BaseModel model) {
        if (null != model && Integer.parseInt(model.getCode()) > 0) {
            if (model.getCode().equals("1")) {
                ConfigValue.uInfor.setBirthday(birthday);
                ConfigValue.uInfor.setSex(String.valueOf(sex));
            }
            Utils.showToast(context, model.getMsg());
        } else
            Utils.showToast(context, "提交失败");
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        File file = new File("/sdcard/onlineshopping/avatar/newhead.jpg");
        if (file.exists())
            file.delete();

    }
}
