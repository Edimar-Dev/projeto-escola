# Sistema de Controle de Resultados de Alunos

Este é um sistema de gestão de resultados acadêmicos para alunos, onde as notas das avaliações de cada matéria são registradas e, com base na média das notas, o status do aluno é atualizado automaticamente. O sistema permite gerenciar alunos, suas matérias e as notas das avaliações, além de fornecer o status do aluno em cada disciplina (Aprovado, Recuperação ou Reprovado).

**Nota:** Inicialmente, os dados serão armazenados em **arrays** em memória. Futuramente, o sistema será migrado para o **Laravel** e os dados serão armazenados em banco de dados relacional.

## Funcionalidades

- **Cadastro de Alunos**: O sistema permite cadastrar alunos com seus dados básicos, como nome e data de nascimento.
- **Cadastro de Matérias**: O sistema permite cadastrar matérias disponíveis para os alunos.
- **Cadastro de Notas**: O sistema permite registrar as notas de 3 avaliações para cada matéria de cada aluno.
- **Cálculo da Média e Status**: A média das 3 notas é calculada automaticamente, e o status do aluno (Aprovado, Recuperação, Reprovado) é atribuído com base na média.

## Estrutura de Dados (Inicialmente com Arrays)

### 1. **Aluno**
Armazena informações sobre os alunos.

- **id_aluno**: Identificador único do aluno.
- **nome**: Nome do aluno.
- **data_nascimento**: Data de nascimento do aluno.
- **cpf**: CPF do aluno (único).

### 2. **Matéria**
Armazena as matérias disponíveis no sistema.

- **id_materia**: Identificador único da matéria.
- **nome_materia**: Nome da matéria.

### 3. **Resultado**
Armazena as notas e o status dos alunos em cada matéria.

- **id_resultado**: Identificador único do resultado.
- **id_aluno**: Referência ao aluno.
- **id_materia**: Referência à matéria.
- **nota_1, nota_2, nota_3**: Notas das 3 avaliações.
- **media**: Média das 3 notas.
- **status**: Status do aluno (Aprovado, Recuperação ou Reprovado).
