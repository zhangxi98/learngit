package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.model.BaseModel;
import com.jsyh.onlineshopping.presenter.ForgetPresenter;
import com.jsyh.onlineshopping.presenter.SendCodePresenter;
import com.jsyh.onlineshopping.utils.CheckUtil;
import com.jsyh.onlineshopping.utils.KeyBoardUtils;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.ForgetView;
import com.jsyh.onlineshopping.views.SendCodeView;

/**
 * Created by sks on 2015/9/17.
 * 找回密码
 */
public class ForgetActivity extends BaseActivity implements View.OnClickListener,
        SendCodeView,ForgetView{
    private Context context;
    TextView title;
    ImageView back;
    private EditText editUserName,editPassword,editAgain,editCode;
    private String name,password,again,code,email;
    private TextView txtEmail;
    private TextView txtCode;
    private TextView btnSure;
    private SendCodePresenter scPresenter;
    private ForgetPresenter fPresenter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forget);
        context = this;
        scPresenter = new SendCodePresenter(this);
        fPresenter = new ForgetPresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("忘记密码");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        editUserName = (EditText) findViewById(R.id.editUserName);
        editPassword = (EditText) findViewById(R.id.editPassword);
        editAgain = (EditText) findViewById(R.id.editAgain);
        editCode = (EditText) findViewById(R.id.editCode);
        txtEmail = (EditText) findViewById(R.id.txtEmail);
        txtCode = (TextView) findViewById(R.id.txtCode);
        btnSure = (TextView) findViewById(R.id.btnSure);
        editUserName.addTextChangedListener(textWatcher);
        editPassword.addTextChangedListener(textWatcher);
        editAgain.addTextChangedListener(textWatcher);
        editCode.addTextChangedListener(textWatcher);
        txtEmail.addTextChangedListener(textWatcher);
        txtCode.setOnClickListener(this);
    }

    private TextWatcher textWatcher = new TextWatcher() {
        @Override
        public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            name = editUserName.getText().toString().trim();
            password = editPassword.getText().toString().trim();
            again = editAgain.getText().toString().trim();
            email = txtEmail.getText().toString().trim();
            code = editCode.getText().toString().trim();
            if(!name.equals("") && !password.equals("") && !again.equals("")
                    && !code.equals("") && !email.equals("")){
                btnSure.setTextColor(getResources().getColor(R.color.white));
                btnSure.setBackgroundResource(R.drawable.login_on_bg);
                btnSure.setClickable(true);
                btnSure.setOnClickListener(ForgetActivity.this);
            }else{
                btnSure.setTextColor(getResources().getColor(R.color.gary_text));
                btnSure.setBackgroundResource(R.drawable.login_off_bg);
                btnSure.setClickable(false);
            }
        }
        @Override
        public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {
        }
        @Override
        public void afterTextChanged(Editable editable) {
        }
    };
    private void sendCode(){
        if(null == name || name.equals("")){
            Utils.showToast(context,"请输入用户名");
            return;
        }
        if(null == email || email.equals("")){
            Utils.showToast(context,"请输入邮箱");
            return;
        }
        if(!CheckUtil.isEmail(email)){
            Utils.showToast(context,"请输入正确的邮箱");
            return;
        }
        scPresenter.setSendCodeView(context,name,email);
    }
    private void submitData(){
        if(!password.equals(again)){
            Utils.showToast(context,"两次输入的密码不一致");
            return;
        }
        fPresenter.submitData(context,code,name,password);
    }

    @Override
    public void getCode(BaseModel response) {
        if(response.getCode().equals("1")){
            txtCode.setTextColor(getResources().getColor(R.color.gary_text));
            txtCode.setBackgroundResource(R.drawable.login_off_bg);
            txtCode.setClickable(false);
        }
        Utils.showToast(context,response.getMsg());
    }

    @Override
    public void getData(BaseModel model) {
        if(model.getCode().equals("1")){
            finish();
        }
        Utils.showToast(context,model.getMsg());
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                KeyBoardUtils.closeKeybord(this);
                break;
            case R.id.txtCode:
                sendCode();
                break;
            case R.id.btnSure:
                submitData();
                break;
        }
    }
}
