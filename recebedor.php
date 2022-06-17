<?php {
    //Serve para carregar o arquivo "TratamentoErro.php" para utulizar suas funções
    include_once 'TratamentoErro.php';
    include_once 'logServ.php';

    //Verificação de Webhook do FaceBook
    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];
    if ($verify_token === 'abc123') { //Codigo de verificação criado
        echo $challenge;
    }

    class webhook
    {

        public function __construct()
        {
            /*******************Trabalhando para receber tudo*******************/
            //Receber o corpo do Json enviado pela instância
            $json = file_get_contents('php://input');
            /*******************Trabalhando para receber tudo*******************/


            /*******************Trabalhando ID FaceBook*******************/
            $decoded = json_decode($json, true); //Decodifica

            //Grava o JSON-body no arquivo de debug
            ob_start();
            var_dump($decoded);
            $input = ob_get_contents();
            ob_end_clean();


            //Coloca para salvar todas as requisições recebidas em um arquivo de log
            //Só para acompanhar o que está recebendo no inicio dos testes
            file_put_contents('Log/inputs.log', $input . PHP_EOL, FILE_APPEND); //cria um log (possível avaliar a anray e trabalhar no caminuo $decoded)


            //Quando receber novo lead no Form, ele chega como ID lead e ID Forms que devem ser armazenados em variaveis para novas consultas
            /* if (isset ($decoded['object'])) {
                $form_id = $decoded['form_id'][]
            }
            */

            //Verifica SE é uma mensagem recebida:
            if (isset($decoded['object'])) {
                $lead = $decoded['entry']['0']['changes']['0']['value']['leadgen_id']; //caminho da anray ($decoded) para chegar no valor 'leadgen_id'
                $form = $decoded['entry']['0']['changes']['0']['value']['form_id']; //caminho da anray ($decoded) para chegar no valor 'form_id'
                file_put_contents('Log/recebidas.log', $lead . '->' . $form . PHP_EOL, FILE_APPEND);
            }
            /*******************Trabalhando ID FaceBook*******************/


            /*******************Buscando dados do Lead no FaceBook*******************/
            //Buscar dados do lead no FaceBook:
            $tokenFace = "Informar o Token aqui";
            $url = "https://graph.facebook.com/v11.0/" . $lead . "/?access_token=" . $tokenFace; //Variavel vai pegar a URL qual vai fazer a requisição
            $ch = curl_init($url); //Iniciando cURL com curl_init(url)
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $resulDecoded = json_decode(curl_exec($ch), true); //Decodifica dados em Json

            ob_start();
            var_dump($resulDecoded);
            $input2 = ob_get_contents();
            ob_end_clean();

            file_put_contents('LeadInputs.log', $input2 . PHP_EOL, FILE_APPEND);


            

            //Verifica SE se recebeu dados do Lead:
            if (isset($resulDecoded['created_time'])) {

                //
                $confere1 = $resulDecoded['field_data']['0']['name'];
                $confere2 = $resulDecoded['field_data']['1']['name'];

                //Leads oficiail1
                if ($confere1 == 'telefone' && $confere2 == 'nome_completo') {
                    $leadName = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }
                
                 //Leads oficiail2
                 else if ($confere1 == 'nome_completo' && $confere2 == 'telefone') {
                    $leadName = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }

                   //Leads oficiail3
                   else if ($confere1 == 'email' && $confere2 == 'nome_completo') {
                    $leadName = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }

                //Leads oficiail4
                else if ($confere1 == 'nome_completo' && $confere2 == 'telefone') {
                    $leadName = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }

                 //Leads oficiail5
                 else if ($confere1 == 'email' && $confere2 == 'telefone') {
                    $leadName = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }

                 //Leads oficiail6
                 else if ($confere1 == 'telefone' && $confere2 == 'email') {
                    $leadName = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }

                //Para testes
                else if ($confere1 == 'nome_completo' && $confere2 == 'email') {
                    $leadName = $resulDecoded['field_data']['0']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Nome do lead'
                    $leadMail = $resulDecoded['field_data']['1']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Email do lead'
                    $leadCell = $resulDecoded['field_data']['2']['values']['0']; //caminho da array ($decoded) para chegar no valor 'Cell do lead'

                    file_put_contents('Log/LeadRecebidas.log', '-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell . PHP_EOL, FILE_APPEND);
                }
            }
            //$resultado = json_decode (curl_exec($ch)); //Decodificando dados em Json
            $resultado = json_encode($resulDecoded); //Transformando Json em Texto
            file_put_contents('Log/buscaLead.log', $resultado . PHP_EOL, FILE_APPEND); //Gravar log
            var_dump($resultado);
            /*******************Buscando dados do Lead no FaceBook*******************/


            /*******************Tratamento de erros*******************/
            $tratamento = new Tratar();
            $telefoneLead = $tratamento->removerNumero($leadCell);
            $emailLead = $tratamento->minusculo($leadMail);
            $nomeLead = $tratamento->removeE($leadName);
            $rendaFamiliar = 0;
            $idEmp = 10;
            /*******************Tratamento de erros*******************/


            /*******************enviar para API*******************/
            try {
                $request = [
                    'id' => 0,
                    'nome' => $nomeLead,
                    'cpf' => "",
                    'email' => $emailLead,
                    'celular' => $telefoneLead,
                    'rendaFamiliar' => $rendaFamiliar,
                    'idEmpreendimento' => $idEmp,
                    'idOrigem' => "4"
                ];


                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://SeuServer',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($request),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic ',
                        'Content-Type: application/json'
                    ),
                ));
                curl_exec($curl);
                curl_close($curl);
                /*******************enviar para API*******************/

                /************ Aqui será enviado para o Servidor "tincDig", na tabela "logLead" as informações de Logs ****/
                $pegaLog = new connect();
                $pegaLog->inserirLog($input,$lead . '->' . $form,$input2,'-> Nome: ' . $leadName . ' -> Email: ' . $leadMail . ' -> Celular: ' . $leadCell,$resultado);
            
            } catch (Exception $e) {
                file_put_contents('Log/ErroLog.log', $e . PHP_EOL, FILE_APPEND);
            }
        }
    }
    new webhook();
}
