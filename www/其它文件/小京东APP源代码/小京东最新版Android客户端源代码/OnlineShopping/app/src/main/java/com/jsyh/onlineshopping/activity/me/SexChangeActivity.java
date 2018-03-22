package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;

/**
 * Created by sks on 2015/9/22.
 */
public class SexChangeActivity extends BaseActivity implements View.OnClickListener {
    TextView title;
    ImageView back;
    private Context context;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_sexchange);
        context = this;
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("修改性别");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        findViewById(R.id.rlMan).setOnClickListener(this);
        findViewById(R.id.rlWoman).setOnClickListener(this);
        findViewById(R.id.rlPrivacy).setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        Intent intent = new Intent();
        switch (view.getId()){
            case R.id.fl_Left:
                finish();
                break;
            case R.id.rlMan:
                setResult(MeAccountActivity.INTENT_MAN,intent);
                finish();
                break;
            case R.id.rlWoman:
                setResult(MeAccountActivity.INTENT_WOMAN,intent);
                finish();
                break;
            case R.id.rlPrivacy:
                setResult(MeAccountActivity.INTENT_PRIVACY,intent);
                finish();
                break;
        }
    }
}
