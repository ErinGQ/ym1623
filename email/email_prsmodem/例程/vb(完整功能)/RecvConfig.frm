VERSION 5.00
Begin VB.Form FormGsmRecvConfig 
   BorderStyle     =   4  'Fixed ToolWindow
   Caption         =   "ѡ��"
   ClientHeight    =   2490
   ClientLeft      =   45
   ClientTop       =   285
   ClientWidth     =   3525
   LinkTopic       =   "Form1"
   MaxButton       =   0   'False
   MinButton       =   0   'False
   ScaleHeight     =   2490
   ScaleWidth      =   3525
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
      Caption         =   "���ն���ѡ��"
      Height          =   1935
      Left            =   0
      TabIndex        =   0
      Top             =   0
      Width           =   3495
      Begin VB.CheckBox checkDelete 
         Caption         =   "���պ��SIM��ɾ������"
         Height          =   375
         Left            =   360
         TabIndex        =   2
         Top             =   480
         Width           =   3000
      End
      Begin VB.ComboBox comboStore 
         Height          =   315
         Left            =   360
         TabIndex        =   1
         Top             =   1200
         Width           =   2655
      End
      Begin VB.Label Label1 
         Caption         =   "���Ŵ洢λ��:"
         Height          =   255
         Left            =   360
         TabIndex        =   3
         Top             =   960
         Width           =   2175
      End
   End
End
Attribute VB_Name = "FormGsmRecvConfig"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Private Sub CancelButton_Click()
    Me.Hide
End Sub

Private Sub Form_Load()
    comboStore.AddItem ("���п���")
    comboStore.AddItem ("SIM��")
    comboStore.AddItem ("�豸")
    comboStore.AddItem ("SIM�����豸")
   
    comboStore.ListIndex = 0
End Sub

Private Sub OKButton_Click()
    Me.Hide
End Sub


