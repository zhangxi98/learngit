package com.jsyh.onlineshopping.model;

import android.os.Parcel;
import android.os.Parcelable;

/**
 * Created by Liang on 2015/9/21.
 *
 * 分类信息
 */
public class CategoryInfo implements Parcelable {

    /**
     *  "classify": "1",
     "classify_name": "sdfasdfsad",
     "goods_img": "sdfasdfasdfsd",
     "parent_id": "sdasdfsad"

     */

    private int classify_id;
    private String classify_name;
    private String goods_img;
    private String parent_id;

    private boolean isChecked;


    public int getClassify_id() {
        return classify_id;
    }

    public void setClassify_id(int classify_id) {
        this.classify_id = classify_id;
    }

    public String getClassify_name() {
        return classify_name;
    }

    public void setClassify_name(String classify_name) {
        this.classify_name = classify_name;
    }

    public String getGoods_img() {
        return goods_img;
    }

    public void setGoods_img(String goods_img) {
        this.goods_img = goods_img;
    }

    public String getParent_id() {
        return parent_id;
    }

    public void setParent_id(String parent_id) {
        this.parent_id = parent_id;
    }

    public boolean isChecked() {
        return isChecked;
    }

    public void setIsChecked(boolean isChecked) {
        this.isChecked = isChecked;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeInt(this.classify_id);
        dest.writeString(this.classify_name);
        dest.writeString(this.goods_img);
        dest.writeByte(isChecked ? (byte) 1 : (byte) 0);
        dest.writeString(this.parent_id);
    }

    public CategoryInfo() {
    }

    protected CategoryInfo(Parcel in) {
        this.classify_id = in.readInt();
        this.classify_name = in.readString();
        this.goods_img = in.readString();
        this.isChecked = in.readByte() != 0;
        this.parent_id = in.readString();
    }

    public static final Parcelable.Creator<CategoryInfo> CREATOR = new Parcelable.Creator<CategoryInfo>() {
        public CategoryInfo createFromParcel(Parcel source) {
            return new CategoryInfo(source);
        }

        public CategoryInfo[] newArray(int size) {
            return new CategoryInfo[size];
        }
    };
}
