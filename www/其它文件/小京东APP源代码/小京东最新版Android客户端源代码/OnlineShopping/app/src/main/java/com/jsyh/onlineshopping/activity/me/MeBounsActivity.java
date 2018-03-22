package com.jsyh.onlineshopping.activity.me;

import android.content.Context;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import com.baoyz.widget.PullRefreshLayout;
import com.jsyh.onlineshopping.R;
import com.jsyh.onlineshopping.activity.BaseActivity;
import com.jsyh.onlineshopping.model.Bouns_me;
import com.jsyh.onlineshopping.model.Bouns_meModel;
import com.jsyh.onlineshopping.presenter.MeBounsPresenter;
import com.jsyh.onlineshopping.utils.Utils;
import com.jsyh.onlineshopping.views.MeBounsView;
import com.jsyh.shopping.uilibrary.adapter.listview.BaseAdapterHelper;
import com.jsyh.shopping.uilibrary.adapter.listview.QuickAdapter;

/**
 * 我的红包
 * Created by gxc on 2016/3/1.
 */
public class MeBounsActivity extends BaseActivity implements View.OnClickListener,MeBounsView {

    private Context context;
    private TextView title;
    private ImageView back;
    private ListView listView;
    private PullRefreshLayout pullRefreshLayout;
    private QuickAdapter<Bouns_me> adapter;
    private MeBounsPresenter presenter;
    private TextView nullData;
    @Override
    public void initView() {
        super.initView();
        setContentView(R.layout.activity_mebouns);
        context = this;
        presenter = new MeBounsPresenter(this);
        title=(TextView)findViewById(R.id.title);
        back = (ImageView)findViewById(R.id.back);
        back.setBackgroundResource(R.mipmap.ic_back);
        title.setText("我的红包");
        findViewById(R.id.fl_Left).setOnClickListener(this);
        nullData = (TextView) findViewById(R.id.null_data);
        pullRefreshLayout = (PullRefreshLayout) findViewById(R.id.pullRefreshLayout);
        pullRefreshLayout.setRefreshStyle(PullRefreshLayout.STYLE_Bitmap);
        pullRefreshLayout.setOnRefreshListener(onRefreshListener);
        listView = (ListView) findViewById(R.id.listView);
        adapter = new QuickAdapter<Bouns_me>(context,R.layout.bouns_item) {
            @Override
            protected void convert(BaseAdapterHelper helper, Bouns_me item) {
                helper.setText(R.id.money,item.getType_money());
                helper.setText(R.id.name,item.getType_name());
                helper.setText(R.id.condition,"满" + item.getMin_goods_amount() + "元可用");
                String start = Utils.time2(context, Long.parseLong(item.getUse_start_date()));
                String end = Utils.time2(context, Long.parseLong(item.getUse_end_date()));
                helper.setText(R.id.time,"有效期：" + start + "至" + end);
                TextView status = helper.getView(R.id.status);
                LinearLayout colorLL = helper.getView(R.id.color_ll);
                ImageView point = helper.getView(R.id.point);
                switch (item.getStatus_num()){
                    case 0:
                        status.setText("未使用");
                        colorLL.setBackgroundResource(R.color.wsy_bg);
                        point.setImageResource(R.mipmap.bouns_content_bg_notused);
                        break;
                    case 1:
                        status.setText("已使用");
                        colorLL.setBackgroundResource(R.color.ysy_bg);
                        point.setImageResource(R.mipmap.bouns_content_bg_hasbeenused);
                        break;
                    case 2:
                        status.setText("未开始");
                        colorLL.setBackgroundResource(R.color.wks_bg);
                        point.setImageResource(R.mipmap.bouns_content_bg_notstarted);
                        break;
                    case 3:
                        status.setText("已过期");
                        colorLL.setBackgroundResource(R.color.ygq_bg);
                        point.setImageResource(R.mipmap.bouns_content_bg_expired);
                        break;

                }
            }
        };
        listView.setAdapter(adapter);
        presenter.loadBouns(context);
    }

    private PullRefreshLayout.OnRefreshListener onRefreshListener = new PullRefreshLayout.OnRefreshListener() {
        @Override
        public void onRefresh() {
            pullRefreshLayout.post(new Runnable() {
                @Override
                public void run() {
                    presenter.loadBouns(context);
                }
            });
        }

        @Override
        public void onMove(boolean ismove) {

        }
    };

    @Override
    public void onClick(View v) {
        finish();
    }

    //得到红包数据
    @Override
    public void getBouns(Bouns_meModel model) {
        pullRefreshLayout.setRefreshing(false);
        if (null != model){
            if (model.getData().size()>0){
                adapter.clear();
                adapter.addAll(model.getData());
            }else {
                nullData.setVisibility(View.VISIBLE);
                pullRefreshLayout.setVisibility(View.GONE);
            }
        }
    }
}
