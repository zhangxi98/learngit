//
//  CouponsViewController.m
//  ecshop
//
//  Created by jsyh-mac on 16/3/2.
//  Copyright © 2016年 jsyh. All rights reserved.
//

#import "CouponsViewController.h"
#import "UIColor+Hex.h"
#import "CouponTableCell.h"
#import "RequestModel.h"
#import "AppDelegate.h"
@interface CouponsViewController ()<UITableViewDataSource,UITableViewDelegate,UIAlertViewDelegate>
@property (nonatomic, strong) UITableView * myTable;
@property (nonatomic, strong) NSMutableArray * dataSource;
@end

@implementation CouponsViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    [self initNavigationBar];
    [self createMyUi];
    [self relodInfomation];
}
-(void)relodInfomation
{
    UIApplication *appli=[UIApplication sharedApplication];
    AppDelegate *app=appli.delegate;
    NSString *api_token = [RequestModel model:@"user" action:@"bonus"];
    NSDictionary *dict = @{@"api_token":api_token,@"key":app.tempDic[@"data"][@"key"]};
    [RequestModel requestWithDictionary:dict model:@"user" action:@"bonus" block:^(id result) {
        if ([result[@"msg"] isEqualToString:@"获取列表失败"]) {
            UIAlertView * alert=[[UIAlertView alloc]initWithTitle:@"提示" message:@"暂无数据" delegate:self cancelButtonTitle:@"确定" otherButtonTitles: nil];
            [alert show];

        }
            [_dataSource addObjectsFromArray:result[@"data"]];
            [_myTable reloadData];

    }];
    
    
}
- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex
{
    if (buttonIndex==0) {
        [self.navigationController popViewControllerAnimated:YES];
    }
}
-(void)createMyUi
{
    _myTable=[[UITableView alloc]initWithFrame:CGRectMake(0, 64, self.view.frame.size.width, self.view.frame.size.height) style:UITableViewStylePlain];
    _myTable.backgroundColor=[UIColor whiteColor];
    _myTable.delegate=self;
    _myTable.dataSource=self;
    _dataSource=[[NSMutableArray alloc]init];
    [self.view addSubview:_myTable];
}
-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return _dataSource.count;
}
-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return 1;
}
-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    static NSString *stringg=@"CouponTableCell";
    CouponTableCell * cell=[tableView dequeueReusableCellWithIdentifier:stringg];
    if (cell==nil) {
        cell = [[[NSBundle mainBundle]loadNibNamed:@"CouponTableCell" owner:self options:nil] lastObject];
    }
   
    cell.nameLab.text=_dataSource[indexPath.row][@"type_name"];
    cell.moneyLab.text= _dataSource[indexPath.row][@"type_money"];
    cell.requireLab.text=[NSString stringWithFormat:@"满%@可以使用",_dataSource[indexPath.row][@"min_goods_amount"]];
    NSString * strr=[NSString stringWithFormat:@"%@",_dataSource[indexPath.row][@"status_num"]];
    cell.stateLab.text=_dataSource[indexPath.row][@"status"];
    
    NSString * time1=_dataSource[indexPath.row][@"use_start_date"];
    NSDate * dt = [NSDate dateWithTimeIntervalSince1970:[time1 floatValue]];
    NSDateFormatter * df = [[NSDateFormatter alloc] init];
    [df setDateFormat:@"YYYY-MM-dd"];
    NSString * startTime = [df stringFromDate:dt];
    
    NSString * time2=_dataSource[indexPath.row][@"use_end_date"];
    NSDate * dt2 = [NSDate dateWithTimeIntervalSince1970:[time2 floatValue]];
    NSDateFormatter * df2 = [[NSDateFormatter alloc] init];
    [df2 setDateFormat:@"YYYY-MM-dd"];
    NSString * endTime = [df2 stringFromDate:dt2];
    cell.timeLab.text=[NSString stringWithFormat:@"有效期:%@至%@",startTime,endTime];
    
    UIImage * imageUser;
    
    if ([strr isEqualToString:@"0"]) {
        cell.timeLab.backgroundColor=[UIColor colorWithRed:244.0/255.0 green:152.0/255.0 blue:145.0/255.0 alpha:1.0];
        cell.stateLab.backgroundColor=[UIColor colorWithRed:244.0/255.0 green:152.0/255.0 blue:145.0/255.0 alpha:1.0];
        imageUser=[UIImage imageNamed:@"bouns_content_bg_notused"];
        imageUser=[imageUser imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
        cell.pictureStateImgView.image=imageUser;
        
    }else if([strr isEqualToString:@"1"] )
    {
        cell.timeLab.backgroundColor=[UIColor colorWithRed:242.0/255.0 green:199.0/255.0 blue:117.0/255.0 alpha:1.0];
         cell.stateLab.backgroundColor=[UIColor colorWithRed:242.0/255.0 green:199.0/255.0 blue:117.0/255.0 alpha:1.0];
        imageUser=[UIImage imageNamed:@"bouns_content_bg_hasbeenused"];
        imageUser=[imageUser imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
        cell.pictureStateImgView.image=imageUser;
    }else if([strr isEqualToString:@"2"] )
    {
        cell.timeLab.backgroundColor=[UIColor colorWithRed:124.0/255.0 green:199.0/255.0 blue:234.0/255.0 alpha:1.0];
        cell.stateLab.backgroundColor=[UIColor colorWithRed:124.0/255.0 green:199.0/255.0 blue:234.0/255.0 alpha:1.0];
        imageUser=[UIImage imageNamed:@"bouns_content_bg_notstarted"];
        imageUser=[imageUser imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
        cell.pictureStateImgView.image=imageUser;
    }
    else if([strr isEqualToString:@"3"] )
    {
        cell.timeLab.backgroundColor=[UIColor colorWithRed:185.0/255.0 green:185.0/255.0 blue: 185.0/255.0 alpha:1.0];
        cell.stateLab.backgroundColor=[UIColor colorWithRed:185.0/255.0 green:185.0/255.0 blue: 185.0/255.0 alpha:1.0];
        imageUser=[UIImage imageNamed:@"bouns_content_bg_expired"];
        imageUser=[imageUser imageWithRenderingMode:UIImageRenderingModeAlwaysOriginal];
        cell.pictureStateImgView.image=imageUser;
    }


        return cell;
}
-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 90;
}
- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/
#pragma mark -- 自定义导航栏
- (void)initNavigationBar{
    
    NSString *plistPath = [[NSBundle mainBundle] pathForResource:@"Setting" ofType:@"plist"];
    NSMutableDictionary *data = [[NSMutableDictionary alloc] initWithContentsOfFile:plistPath];
    NSString *naviBGColor = data[@"navigationBGColor"];
    NSString *navigationTitleFont = data[@"navigationTitleFont"];
    int titleFont = [navigationTitleFont intValue];
    NSString *naiigationTitleColor = data[@"naiigationTitleColor"];
    
    [self.navigationController setNavigationBarHidden:YES animated:NO];
    UIView *view = [[UIView alloc]initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, 64)];
    view.backgroundColor = [UIColor colorWithHexString:naviBGColor];
    UILabel  *labelTitle = [[UILabel alloc]initWithFrame:CGRectMake(100, 20, self.view.frame.size.width - 200, 44)];
    
    labelTitle.text = @"我的红包";
    
    labelTitle.textAlignment = NSTextAlignmentCenter;
    labelTitle.font = [UIFont systemFontOfSize:titleFont];
    labelTitle.textColor = [UIColor colorWithHexString:naiigationTitleColor];
    [view addSubview:labelTitle];
    
    UIImage *img = [UIImage imageNamed:@"back.png"];
    UIImageView *imgView = [[UIImageView alloc]initWithFrame:CGRectMake(12, 12, 20, 20)];
    imgView.image = img;
    UIButton *btn = [[UIButton alloc]initWithFrame:CGRectMake(0, 20, 40, 40)];
    [btn addSubview:imgView];
    [btn addTarget:self action:@selector(back) forControlEvents:UIControlEventTouchUpInside];
    [view addSubview:btn];
    [self.view addSubview:view];
    
    
}
-(void)back{
    [self.navigationController popViewControllerAnimated:YES];
}
@end
