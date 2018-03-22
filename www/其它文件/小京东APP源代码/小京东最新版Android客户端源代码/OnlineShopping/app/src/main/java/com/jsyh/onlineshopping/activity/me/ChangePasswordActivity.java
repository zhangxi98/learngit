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
import com.jsyh.onlineshopping.presenter.ChangePasswordPresenter;
import com.jsyh.onlineshopping.utils.KeyBoardUtils;
import com.jsyh.onlineshopping.utils.Utils;

/**
 * Created by sks on 2015/9/17.
 * 修改密码
 */
public class ChangePasswordActivity extends BaseActivity implements View.OnClickListener{
    TextView title;
    ImageView back;
    private Context context;
    private EditText editUserName,editOldPassword,editNewPassword,editAgain;
    private TextView btnSure;
    private String name,oldPass,newPass,again;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_changepassword);
        context = this;
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("修改密码");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        editUserName = (EditText) findViewById(R.id.editUserName);
        editOldPassword = (EditText) findViewById(R.id.editOldPassword);
        editNewPassword = (EditText) findViewById(R.id.editNewPassword);
        editAgain = (EditText) findViewById(R.id.editAgain);
        btnSure = (TextView) findViewById(R.id.btnSure);
        editUserName.addTextChangedListener(textWatcher);
        editOldPassword.addTextChangedListener(textWatcher);
        editNewPassword.addTextChangedListener(textWatcher);
        editAgain.addTextChangedListener(textWatcher);
    }

    private TextWatcher textWatcher = new TextWatcher() {
        @Override
        public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {
        }
        @Override
        public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
            name = editUserName.getText().toString().trim();
            oldPass = editOldPassword.getText().toString().trim();
            newPass = editNewPassword.getText().toString().trim();
            again = editAgain.getText().toString().trim();
            if(!name.equals("") && !oldPass.equals("") && !again.equals("")
                    && !newPass.equals("")){
                btnSure.setTextColor(getResources().getColor(R.color.white));
                btnSure.setBackgroundResource(R.drawable.login_on_bg);
                btnSure.setClickable(true);
                btnSure.setOnClickListener(ChangePasswordActivity.this);
            }else{
                btnSure.setTextColor(getResources().getColor(R.color.gary_text));
                btnSure.setBackgroundResource(R.drawable.login_off_bg);
                btnSure.setClickable(false);
            }
        }
        @Override
        public void afterTextChanged(Editable editable) {
        }
    };
    private void submit(){
        if(!newPass.equals(again)){
            Utils.showToast(context,"两次输入的密码不一致");
            return;
        }
        new ChangePasswordPresenter(context).submitChangeInfor(name,oldPass,newPass);
    }
    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.fl_Left:
                KeyBoardUtils.closeKeybord(this);
                break;
            case R.id.btnSure:
                submit();
                break;
        }
    }
}
