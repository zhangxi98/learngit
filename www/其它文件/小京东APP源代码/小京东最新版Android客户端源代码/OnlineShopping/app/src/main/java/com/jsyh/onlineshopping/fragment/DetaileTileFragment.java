package com.jsyh.onlineshopping.fragment;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.jsyh.onlineshopping.R;

public class DetaileTileFragment extends BaseFragment {
    private LinearLayout layout_Menu;


    private TextView mHome;        //回到首页
    private TextView mSearch;
    private TextView mShare;        //分享

    private ClickCallback cc;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        View view = inflater.inflate(R.layout.detatil_menu, null);


        view.setVisibility(View.GONE);
        return view;
    }

    @Override
    protected void initView() {
        layout_Menu = (LinearLayout) getView().findViewById(R.id.layout_Menu);

        mHome = (TextView) getView().findViewById(R.id.tvHome);
        mHome.setOnClickListener(this);


        mSearch = (TextView) getView().findViewById(R.id.tvSearch);
        mSearch.setOnClickListener(this);

        mShare = (TextView) getView().findViewById(R.id.tvShare);
        mShare.setOnClickListener(this);

        LinearLayout mLayoutOut = (LinearLayout) getView().findViewById(R.id.mLayoutOut);
        mLayoutOut.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                hide();
            }
        });
    }

    @Override
    protected void initTitle() {
    }

    public void hide() {
        // TODO Auto-generated method stub
        layout_Menu.startAnimation(AnimationUtils.loadAnimation(getActivity(), R.anim.slid_out));
        getView().setVisibility(View.GONE);

    }

    public boolean isShow() {
        return getView().isShown();
    }

    public void show() {
        // TODO Auto-generated method stub
        layout_Menu.startAnimation(AnimationUtils.loadAnimation(getActivity(), R.anim.slid_in));
        getView().setVisibility(View.VISIBLE);
    }

    public interface ClickCallback {
        void shareClick();

        void searchClick();

        void homeClick();
    }

    public void shareClick(ClickCallback cc) {
        this.cc = cc;
    }

    @Override
    public void onClick(View v) {


        switch (v.getId()) {

            case R.id.tvHome:

                cc.homeClick();

                break;

            case R.id.tvSearch:
                cc.searchClick();
                break;
            case R.id.tvShare:
                cc.shareClick();
                break;

        }

    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        cc = (ClickCallback) context;
    }
}
