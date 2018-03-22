package com.jsyh.onlineshopping.activity;

import android.os.Bundle;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;

import com.jsyh.onlineshopping.fragment.DetatileFragment;
import com.jsyh.shopping.uilibrary.R;


public class DetatileActivity extends BaseActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);


        Bundle extras = getIntent().getExtras();

        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();

        DetatileFragment detatileFragment = DetatileFragment.newInstance(extras);
        fragmentTransaction.add(R.id.framelayout, detatileFragment, "detatileFragment");
        fragmentTransaction.commit();
    }
}
