/**
 * @share [id]/edit
 */
import { CListBtn } from '@mxjs/a-clink';
import { Page, PageActions } from '@mxjs/a-page';
import { Form, FormItem, FormActions } from '@mxjs/a-form';
import { Select } from '@miaoxing/admin';
import { Switch } from 'antd';
import { Section } from '@mxjs/a-section';

const New = () => {
  return (
    <Page>
      <PageActions>
        <CListBtn/>
      </PageActions>

      <Form>
        {({id}) => {
          return <>
            <Section>
              <FormItem label="名称" name="name" type={id ? 'plain' : 'text'} required/>

              <FormItem label="类型" name="type" required>
                <Select url="consts/globalConfigModel-type" labelKey="name" valueKey="id"/>
              </FormItem>

              <FormItem label="值" name="value" required/>

              <FormItem label="是否预加载" name="preload" required valuePropName="checked">
                <Switch/>
              </FormItem>

              <FormItem label="注释" name="comment" type="textarea"/>
            </Section>
            <FormActions/>
          </>;
        }}
      </Form>
    </Page>
  );
};

export default New;
