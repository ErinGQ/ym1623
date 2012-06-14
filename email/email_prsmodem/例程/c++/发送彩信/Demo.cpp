
#include <windows.h>
#include <stdio.h>
#include <comdef.h>
#include <atlbase.h>

#include "smmsConstants.h"
#include "xssmsmms.h"
#include "xssmsmms_i.c"

LPSTR ReadInput( LPCSTR lpszTitle, BOOL bAllowEmpty = FALSE );
void ReadMm1Provider( IMmsProtocolMm1 *pMm1Protocol );

LPSTR AskDevice( IMmsProtocolMm1 *pMm1Protocol );
LPSTR GetErrorDescription( LONG lLastError, IMmsProtocolMm1 *pMm1Protocol );


int main(int argc, char* argv[])
{
	IMmsProtocolMm1     *pMm1Protocol		= NULL;
	IMmsSlide			*pSlide	    = NULL;
	IMmsMessage			*pMessage   = NULL;
	LPSTR				lpszPincode	= NULL;
	HRESULT				hr;
	LONG				lLastError;

	 
	CoInitialize(NULL);
	
	hr = CoCreateInstance(CLSID_MmsProtocolMm1, NULL, CLSCTX_INPROC_SERVER, IID_IMmsProtocolMm1, (void**) &pMm1Protocol);
	if( SUCCEEDED( hr ) )
		hr = CoCreateInstance(CLSID_MmsSlide, NULL, CLSCTX_INPROC_SERVER, IID_IMmsSlide, (void**) &pSlide );
	if( SUCCEEDED( hr ) )
		hr = CoCreateInstance(CLSID_MmsMessage, NULL, CLSCTX_INPROC_SERVER, IID_IMmsMessage, (void**) &pMessage );
	if( ! SUCCEEDED( hr ) )
	{
		printf( "�޷���������.\n" );
		goto _EndMain;
	}

	pSlide->Clear();

	// ���ӻõ�Ƭ�е�ͼƬ���ı�
	pSlide->AddAttachment( _bstr_t( "test.jpg" ) );
	pSlide->AddText( _bstr_t( "������������ı���Ϣ" ) );

	pMessage->Clear();

	// �����ߺ���
	pMessage->AddRecipient( _bstr_t( ReadInput( "��������ߺ���(���������'+86'��ͷ)" ) ), asMMS_RECIPIENT_TO  );
	
	// ��������
	pMessage->put_Subject( _bstr_t("�˴�Ϊ��������")  );

	// ���ӻõ�Ƭ
	pMessage->AddSlide( &_variant_t ( ( IDispatch*) pSlide ) );

	pMm1Protocol->Clear();

	// ѡ�����豸
	pMm1Protocol->put_Device( _bstr_t( "��׼ 33600 bps ���ƽ����" ) );

	// �й��ƶ����ŷ�������
	pMm1Protocol->put_ProviderMMSC( _bstr_t("http://mmsc.monternet.com") );
	pMm1Protocol->put_ProviderAPN( _bstr_t( "cmwap" ) );
    pMm1Protocol->put_ProviderAPNAccount( _bstr_t( "") );
	pMm1Protocol->put_ProviderAPNPassword( _bstr_t( "") );
	pMm1Protocol->put_ProviderWAPGateway( _bstr_t( "10.0.0.172" ) );

    /* �й��ƶ����ŷ�������
	pMm1Protocol->put_ProviderMMSC( _bstr_t( "http://mmsc.myuni.com.cn" ) );
	pMm1Protocol->put_ProviderAPN( _bstr_t( "UNIWAP" ) );
    pMm1Protocol->put_ProviderAPNAccount( _bstr_t( "") );
	pMm1Protocol->put_ProviderAPNPassword( _bstr_t( "") );
	pMm1Protocol->put_ProviderWAPGateway( _bstr_t( "10.0.0.172" ) );
	*/


	// ����gprs����
	printf( "���ڲ���gprs����...\n" );
	pMm1Protocol->Connect();
	pMm1Protocol->get_LastError( &lLastError );
	printf( "���: %ld (%s)\n\n", lLastError, GetErrorDescription( lLastError, pMm1Protocol ) );
	if( lLastError != 0L )
		goto _EndMain;

	// ���Ͳ���
	printf( "���ڷ���...\n" );
	pMm1Protocol->Send( &_variant_t ( ( IDispatch*) pMessage ) );
	pMm1Protocol->get_LastError( &lLastError );
	printf( "���: %ld (%s)\n\n", lLastError, GetErrorDescription( lLastError, pMm1Protocol ) );


_EndMain:

	if( pMm1Protocol != NULL ) 
	{
		pMm1Protocol->Disconnect();
		pMm1Protocol->Release();
	}

	if( pMessage != NULL ) 
		pMessage->Release();

	if( pSlide != NULL ) 
		pSlide->Release();

	CoUninitialize();

	printf("����.......\n");

	return 0;
}

///////////////////////////////////////////////////////////////////////////////////////////

LPSTR ReadInput( LPCSTR lpszTitle, BOOL bAllowEmpty )
{
	static CHAR		szInput [ 255 + 1 ] = { 0 };

	printf ( "%s:\n", lpszTitle );
	do
	{
		printf ( "   > " );
		// scanf ( "%s", szInput );
		fflush(stdin); 
		fflush(stdout); 
		fgets( szInput, 255, stdin );
		if( szInput[ 0 ] != '\0' && szInput[ strlen( szInput ) - 1  ] == '\n' )
			szInput[ strlen( szInput ) - 1  ] = '\0';
	} while( lstrlen ( szInput ) == 0 && ! bAllowEmpty );
	printf( "\n" );

	return szInput;
}

///////////////////////////////////////////////////////////////////////////////////////////

LPSTR GetErrorDescription( LONG lLastError, IMmsProtocolMm1 *pMm1Protocol )
{
	static CHAR		szErrorDescription[ 1024 + 1 ] = { 0 };
	BSTR			bstrErrDescr = NULL;

	szErrorDescription[ 0 ] = '\0';
	pMm1Protocol->GetErrorDescription( lLastError, &bstrErrDescr );
	if( bstrErrDescr != NULL )
	{
		sprintf( szErrorDescription, "%ls", bstrErrDescr );
		SysFreeString ( bstrErrDescr );

	}
	return szErrorDescription;
}


///////////////////////////////////////////////////////////////////////////////////////////

