package com.jsyh.shopping.uilibrary.adapter;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import com.jsyh.shopping.uilibrary.views.ImageFragment;

public class DemoPagerAdapter extends FragmentPagerAdapter {
	private Context context;
	public DemoPagerAdapter(FragmentManager fm,Context context) {
		super(fm);
		this.context = context;
		// TODO Auto-generated constructor stub
	}

	@Override
	public Fragment getItem(int arg0) {
		// TODO Auto-generated method stub
		return ImageFragment.newInstance(arg0,context);
	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return ImageFragment.image.length;
	}
}
