
#include <windows.h>
#include <stdio.h>
#include <comdef.h>
#include <atlbase.h>

#include "smmsConstants.h"
#include "xssmsmms.h"
#include "xssmsmms_i.c"

LPSTR ReadInput( LPCSTR lpszTitle, BOOL bAllowEmpty = FALSE );
LPSTR AskDevice( ISmsProtocolGsm *pGsm );
LPSTR GetErrorDescription( LONG lLastError, ISmsProtocolGsm *pGsm );


int main(int argc, char* argv[])
{
	ISmsProtocolGsm     *pGsm		= NULL;
	ISmsMessage			*pMessage   = NULL;
	ISmsDeliveryStatus	*pDeliveryStatus	= NULL;
	LPSTR				lpszMessage	= NULL;
	LPSTR				lpszPincode	= NULL;
	BSTR				bstrMessageReference = NULL;
	VARIANT				vtVar;
	HRESULT				hr;
	LONG				lLastError;
	char				*cp;
	BOOL				bRequestDeliveryReport	= FALSE;
	LONG				lDeliveryStatus = 0L, lDeliveryStatusCode = 0L;
	BSTR				bstrDeliveryStatusTime	= NULL, bstrStatusDescription = NULL;
	BOOL				bDeliveryCompleted = FALSE;

	
	CoInitialize(NULL);

	VariantInit( &vtVar );

	
	hr = CoCreateInstance(CLSID_SmsProtocolGsm, NULL, CLSCTX_INPROC_SERVER, IID_ISmsProtocolGsm, (void**) &pGsm);
	if( SUCCEEDED( hr ) )
		hr = CoCreateInstance(CLSID_SmsMessage, NULL, CLSCTX_INPROC_SERVER, IID_ISmsMessage, (void**) &pMessage );
	if( ! SUCCEEDED( hr ) )
	{
		printf( "�޷���������\n" );
		goto _EndMain;
	}

	// ѡ���豸
	pGsm->put_Device( _bstr_t( "COM1" ) );

	pMessage->Clear();

	// �����ߺ���
	pMessage->put_Recipient( _bstr_t( ReadInput( "��������ߺ��룬���������+86��ͷ" ) ) );

	//������ű��뷽ʽ
	pMessage->put_Format( asMESSAGEFORMAT_UNICODE_MULTIPART );


	// ��������
	lpszMessage = ReadInput( "�����������" );
	pMessage->put_Data( _bstr_t( lpszMessage ) );

	printf( "���ڷ�����Ϣ...\n" );
    pGsm->Send( &_variant_t ( ( IDispatch*) pMessage ), &bstrMessageReference );
	pGsm->get_LastError( &lLastError );
	printf( "���ͽ��: %ld (%s)\n\n", lLastError, GetErrorDescription( lLastError, pGsm ) );

	goto _EndMain;

_EndMain:

	if( pGsm != NULL ) 
		pGsm->Release();

	if( pMessage != NULL ) 
		pMessage->Release();

	if( bstrMessageReference != NULL )
		SysFreeString( bstrMessageReference );

	CoUninitialize();

	printf("����...\n");

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

LPSTR GetErrorDescription( LONG lLastError, ISmsProtocolGsm *pGsm )
{
	static CHAR		szErrorDescription[ 1024 + 1 ] = { 0 };
	BSTR			bstrErrDescr = NULL;

	szErrorDescription[ 0 ] = '\0';
	pGsm->GetErrorDescription( lLastError, &bstrErrDescr );
	if( bstrErrDescr != NULL )
	{
		sprintf( szErrorDescription, "%ls", bstrErrDescr );
		SysFreeString ( bstrErrDescr );

	}
	return szErrorDescription;
}


///////////////////////////////////////////////////////////////////////////////////////////

