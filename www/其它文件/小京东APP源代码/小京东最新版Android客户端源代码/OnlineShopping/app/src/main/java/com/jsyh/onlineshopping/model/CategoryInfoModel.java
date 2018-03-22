package com.jsyh.onlineshopping.model;

import android.os.Parcel;
import android.os.Parcelable;

import java.util.List;

/**
 * 分类
 */
public class CategoryInfoModel implements Parcelable {

    private Data data;

    public Data getData() {
        return data;
    }

    public void setData(Data data) {
        this.data = data;
    }

    public static class Data implements Parcelable {


        private List<CategoryInfo> classify;

        private List<CategoryAdvInfo> product;


        public List<CategoryInfo> getClassify() {
            return classify;
        }

        public void setClassify(List<CategoryInfo> classify) {
            this.classify = classify;
        }

        public List<CategoryAdvInfo> getProduct() {
            return product;
        }

        public void setProduct(List<CategoryAdvInfo> product) {
            this.product = product;
        }

        @Override
        public int describeContents() {
            return 0;
        }

        @Override
        public void writeToParcel(Parcel dest, int flags) {
            dest.writeTypedList(classify);
            dest.writeTypedList(product);
        }

        public Data() {
        }

        protected Data(Parcel in) {
            this.classify = in.createTypedArrayList(CategoryInfo.CREATOR);
            this.product = in.createTypedArrayList(CategoryAdvInfo.CREATOR);
        }

        public static final Parcelable.Creator<Data> CREATOR = new Parcelable.Creator<Data>() {
            public Data createFromParcel(Parcel source) {
                return new Data(source);
            }

            public Data[] newArray(int size) {
                return new Data[size];
            }
        };
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeParcelable(this.data, 0);
    }

    public CategoryInfoModel() {
    }

    protected CategoryInfoModel(Parcel in) {
        this.data = in.readParcelable(Data.class.getClassLoader());
    }

    public static final Parcelable.Creator<CategoryInfoModel> CREATOR = new Parcelable.Creator<CategoryInfoModel>() {
        public CategoryInfoModel createFromParcel(Parcel source) {
            return new CategoryInfoModel(source);
        }

        public CategoryInfoModel[] newArray(int size) {
            return new CategoryInfoModel[size];
        }
    };
}
