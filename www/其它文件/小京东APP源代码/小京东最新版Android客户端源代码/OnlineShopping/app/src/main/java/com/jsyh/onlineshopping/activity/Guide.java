package com.jsyh.onlineshopping.activity;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.view.ViewPager;

import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.utils.AppManager;
import com.jsyh.shopping.uilibrary.adapter.DemoPagerAdapter;
import com.jsyh.shopping.uilibrary.views.CircleIndicator;
import com.jsyh.shopping.uilibrary.views.ImageFragment;

/**
 * 引导页
 * Created by sks on 2015/12/4.
 */
public class Guide extends FragmentActivity implements ImageFragment.IntentBack {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_guide);

        ViewPager defaultViewpager = (ViewPager) findViewById(R.id.viewpager_default);
        CircleIndicator defaultIndicator = (CircleIndicator) findViewById(R.id.indicator_default);
        DemoPagerAdapter defaultPagerAdapter = new DemoPagerAdapter(getSupportFragmentManager(),this);
        defaultViewpager.setAdapter(defaultPagerAdapter);
        defaultIndicator.setViewPager(defaultViewpager);
        AppManager.getAppManager().addActivity(Guide.this);
    }

    @Override
    public void getIntentCallBack() {
        Intent intent = new Intent(this,MainActivity.class);
        startActivity(intent);
        finish();
    }
}
