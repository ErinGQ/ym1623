VERSION 5.00
Begin VB.Form FormSendConfig 
   BorderStyle     =   4  'Fixed ToolWindow
   Caption         =   "ѡ��"
   ClientHeight    =   2460
   ClientLeft      =   45
   ClientTop       =   285
   ClientWidth     =   3540
   LinkTopic       =   "Form1"
   MaxButton       =   0   'False
   MinButton       =   0   'False
   ScaleHeight     =   2460
   ScaleWidth      =   3540
   ShowInTaskbar   =   0   'False
   StartUpPosition =   2  '��Ļ����
   Begin VB.CommandButton OKButton 
      Caption         =   "ȷ��"
      Height          =   375
      Left            =   960
      TabIndex        =   5
      Top             =   2040
      Width           =   1215
   End
   Begin VB.CommandButton CancelButton 
      Caption         =   "ȡ��"
      Height          =   375
      Left            =   2280
      TabIndex        =   4
      Top             =   2040
      Width           =   1215
   End
   Begin VB.Frame Frame1 
      Caption         =   "����ѡ��"
      Height          =   1935
      Left            =   0
      TabIndex        =   0
      Top             =   0
      Width           =   3495
      Begin VB.CheckBox checkUDH 
         Caption         =   "UDH"
         Height          =   255
         Left            =   360
         TabIndex        =   6
         Top             =   1440
         Width           =   2415
      End
      Begin VB.CheckBox checkMultipart 
         Caption         =   "���������Զ�ƴ��"
         Height          =   255
         Left            =   360
         TabIndex        =   3
         Top             =   360
         Width           =   2415
      End
      Begin VB.CheckBox checkFlash 
         Caption         =   "����"
         Height          =   195
         Left            =   360
         TabIndex        =   2
         Top             =   720
         Width           =   2295
      End
      Begin VB.CheckBox checkReport 
         Caption         =   "���󵽴��ִ"
         Height          =   255
         Left            =   360
         TabIndex        =   1
         Top             =   1080
         Width           =   2055
      End
   End
End
Attribute VB_Name = "FormSendConfig"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Private Sub CancelButton_Click()
    Me.Hide
End Sub


Private Sub OKButton_Click()
    Me.Hide
End Sub
