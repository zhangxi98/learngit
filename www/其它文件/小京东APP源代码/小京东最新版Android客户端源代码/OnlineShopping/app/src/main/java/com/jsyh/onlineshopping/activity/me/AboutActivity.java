package com.jsyh.onlineshopping.activity.me;

import android.view.View;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;

/**
 * Created by sks on 2015/10/20.
 * 关于
 */
public class AboutActivity extends BaseActivity {
    TextView title;
    ImageView back;
    FrameLayout left;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_about);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        left = (FrameLayout) findViewById(R.id.fl_Left);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("关于");
        left.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
    }
}
