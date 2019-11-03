<?php
class Nfe extends Model
{
    public function emitirNFE($cNF, $destinatario, $prods)
    {
        $nfe = new Make();
        //$nfeTools = new NfePHP\NFe\ToolsNFe(BASE_URL . "nfe/files/config.json");

        //Node principal
        $std = new stdClass();
        $std->versao = '4.00'; //versão do layout
        //$std->Id = 'NFe35150271780456000160550010000000021800700082'; //se o Id de 44 digitos não for passado será gerado automaticamente
        $std->pk_nItem = null; //deixe essa variavel sempre como NULL
        $nfe->taginfNFe($std);

        //Node identificação da NFe
        $std = new stdClass();
        //Dados da NFe - infNFe
        $std->cUF = '42'; //codigo numerico do estado
        //$cNF = '00000010'; //numero aleatório da NF
        $std->natOp = 'Venda de Produto'; //natureza da operação
        $std->indPag = '0'; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
        $std->mod = '55'; //modelo da NFe 55 ou 65 essa última NFCe
        $std->serie = '1'; //serie da NFe
        $std->nNF = $cNF; // numero da NFe
        $std->dhEmi = date("Y-m-d\TH:i:sP"); //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
        $std->dhSaiEnt = date("Y-m-d\TH:i:sP"); //Não informar este campo para a NFC-e.
        $std->tpNF = '1'; //0=Entrada;1=Saida
        $std->idDest = '1'; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
        $std->cMunFG = '4212205';
        $std->tpImp = '1'; //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;
        //3=DANFE Simplificado; 4=DANFE NFC-e; 5=DANFE NFC-e em mensagem eletrônica
        //(o envio de mensagem eletrônica pode ser feita de forma simultânea com a impressão do DANFE;
        //usar o tpImp=5 quando esta for a única forma de disponibilização do DANFE).
        $std->tpEmis = '1'; //1=Emissão normal (não em contingência);
        //2=Contingência FS-IA, com impressão do DANFE em formulário de segurança;
        //3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional);
        //4=Contingência DPEC (Declaração Prévia da Emissão em Contingência);
        //5=Contingência FS-DA, com impressão do DANFE em formulário de segurança;
        //6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
        //7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
        //9=Contingência off-line da NFC-e (as demais opções de contingência são válidas também para a NFC-e);
        //Nota: Para a NFC-e somente estão disponíveis e são válidas as opções de contingência 5 e 9.
        $std->tpAmb = '2'; //1=Produção; 2=Homologação
        $std->finNFe = '1'; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
        $std->indFinal = '1'; //0=Normal; 1=Consumidor final;
        $std->indPres = '2'; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
        //1=Operação presencial;
        //2=Operação não presencial, pela Internet;
        //3=Operação não presencial, Teleatendimento;
        //4=NFC-e em operação com entrega a domicílio;
        //9=Operação não presencial, outros.
        $std->procEmi = '3.10.31'; //0=Emissão de NF-e com aplicativo do contribuinte;
        //1=Emissão de NF-e avulsa pelo Fisco;
        //2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
        //3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
        $std->verProc = '4.0.43'; //versão do aplicativo emissor
        $std->dhCont = null; //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
        $std->xJust = null; //Justificativa da entrada em contingência

        $nfe->tagide($std);

        //Dados do emitente - (Importando dados do config.json)
        $std = new stdClass();
        $std->CNPJ = '09450379000106';
        $std->CPF = ''; // Utilizado para CPF na nota
        $std->xNome = "JRHM MADEIRAS C. I. e E. LTDA";
        $std->xFant = "MADESUL MADEIRAS";
        $std->IE = "255584113";
        $std->IEST = null;
        $std->IM = null;
        $std->CNAE = null;
        $std->CRT = null;
        $std->resp = $nfe->tagemit($std);

        //endereço do emitente
        $std = new stdClass();
        $std->xLgr = 'Rua Mafra';
        $std->nro = '117';
        $std->xCpl = null;
        $std->xBairro = 'Centro';
        $std->cMun = '4212205';
        $std->xMun = 'Papanduva';
        $std->UF = 'SC';
        $std->CEP = '89370000';
        $std->cPais = '1058';
        $std->xPais = 'Brasil';
        $std->fone = '47992662121';
        $std->resp = $nfe->tagenderEmit($std);

        //destinatário
        $std = new stdClass();
        $std->CNPJ = $destinatario['cnpj'] ?? null;
        $std->CPF = $destinatario['cpf'] ?? null;
        $std->idEstrangeiro = $destinatario['idEstrangeiro'] ?? null;
        $std->xNome = $destinatario['nome'] ?? null;
        $std->indIEDest = $destinatario['iedest'] ?? null;
        $std->IE = $destinatario['ie'] ?? null;
        $std->ISUF = $destinatario['isuf'] ?? null;
        $std->IM = $destinatario['cpf'] ?? '4212205';
        $std->email = $destinatario['email'] ?? "douglaspoma@yahoo.com";
        $nfe->tagdest($std);

        //Endereço do destinatário
        $std = new stdClass();
        $std->xLgr = $destinatario['end']['lgr'] ?? "Jorge Lacerda";
        $std->nro = $destinatario['end']['nro'] ?? "1084";
        $std->xCpl = $destinatario['end']['comp'] ?? null;
        $std->xBairro = $destinatario['end']['bairro'] ?? "Centro";
        $std->cMun = $destinatario['end']['nMun'] ?? '4212205';
        $std->xMun = $destinatario['end']['codade'] ?? 'Papanduva';
        $std->UF = $destinatario['end']['uf'] ?? 'SC';
        $std->CEP = $destinatario['end']['cep'] ?? '89370000';
        $std->cPais = $destinatario['end']['cPais'] ?? '1058';
        $std->xPais = $destinatario['end']['pais'] ?? 'Brasil';
        $std->fone = $destinatario['end']['fone'] ?? '47992662121';
        $nfe->tagenderDest($std);

        //inicialização variaveis
        $std = new stdClass();
        $std->vBC = 0;
        $std->vICMSDeson = 0;
        $std->vProdT = 0;
        $std->vFreteT = 0; 
        $std->vSegT = 0;
        $std->vDescT = 0;
        $std->vOutroT = 0;
        $std->vII = 0;
        $std->vIPI = 0;
        $std->vIOF = 0;
        $std->vPIS = 0;
        $std->vCOFINS = 0;
        $std->vICMS = 0;
        $std->vBCST = 0;
        $std->vST = 0;
        $std->vISS = 0;
        $i = 1;
        foreach ($prods as $p) {
            $std->item = $i; //item da NFe
            $std->cProd = $p['cProd'];
            $std->cEAN = $p['cEAN'];
            $std->xProd = $p['xProd'];
            $std->NCM = $p['NCM'];

            $std->cBenef = $p['cBenef']; //incluido no layout 4.00

            $std->EXTIPI = $p['EXTIPI'];
            $std->CFOP = $p['CFOP'];
            $std->uCom = $p['uCom'];
            $std->qCom = $p['qCom'];
            $std->vUnCom = $p['vUnCom'];
            $std->vProdT += $p['vProd'];
            $std->vProd += $p['vProd'];
            $std->cEANTrib = $p['cEANTrib'];
            $std->uTrib = $p['uTrib'];
            $std->qTrib = $p['qTrib'];
            $std->vUnTrib = $p['vUnTrib'];
            $std->vFreteT = $p['vFrete'];
            $std->vFrete = $p['vFrete'];
            $std->vSegT += $p['vSeg'];
            $std->vSeg += $p['vSeg'];
            $std->vDescT += $p['vDesc'];
            $std->vDesc += $p['vDesc'];
            $std->vOutroT += $p['vOutro'];
            $std->vOutro += $p['vOutro'];
            $std->indTot = $p['indTot'];
            $std->xPed = $p['xPed'];
            $std->nItemPed = $p['nItemPed'];
            $std->nFCI = $p['nFCI'];
            $std->vBC += $p['vBC'];


            $nfe->tagprod($std);
            $i++;
        }

        $nfe->tagICMS($std);

    }

}
